<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('profile.edit') || $this->param('profile.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$defaultFormat = static fn($v) => $v;

// Изменяемые свойства
$props = [];

$props[] = ['Имя'                  , $data['name']['first'   ] ?? '', [$record, 'firstName'      ], [$record, 'setFirstName'      ], $defaultFormat];
$props[] = ['Фамилия'              , $data['name']['last'    ] ?? '', [$record, 'lastName'       ], [$record, 'setLastName'       ], $defaultFormat];
$props[] = ['Отчество'             , $data['name']['middle'  ] ?? '', [$record, 'middleName'     ], [$record, 'setMiddleName'     ], $defaultFormat];
$props[] = ['Должность'            , $data['post']             ?? '', [$record, 'post'           ], [$record, 'setPost'           ], $defaultFormat];
$props[] = ['Контакты'             , $data['contacts']         ?? '', [$record, 'contactsRaw'    ], [$record, 'setContactsRaw'    ], $defaultFormat];
$props[] = ['Заметки'              , $data['comment']          ?? '', [$record, 'comment'        ], [$record, 'setComment'        ], $defaultFormat];

$changes = [];

$oldName = $record->fullName();

foreach ($props as [$prop, $new, $getter, $setter, $format]) {
    $old = $getter();

    if (is_array($old) || is_array($new)) {
        $diff = \Data\ArrayUtils::calcChanges((array) $old, (array) $new);

        if ($diff) {
            $setter($new);
            if ($prop === 'Контакты') {
                $changes[] = 'Изменено поле «<b>' . $prop . '</b>»: <pre class="diff">' . Html(text_udiff(contactsToList($old), contactsToList($new))) . '</pre>';
            } else {
                $changes[] = 'Изменено поле «<b>' . $prop . '</b>»: <ul><li>' . join('</li><li>', \Data\ArrayUtils::changesToTextArray($diff)) . '</li></ul>';
            }
        }
    } elseif ($old != $new) {
        $setter($new);
        $changes[] = sprintf('Изменено поле «<b>%s</b>»: «%s» => «%s»', $prop, $format($old), $format($new));
    }
}

if ($changes) {
    $record->save();
    $record->addHistory('В пользователя <b data-profile>' . $oldName . '</b> внесены изменения: <ul><li>' . join('</li><li>', $changes) . '</li></ul>');
}

$this->include('data.php');
