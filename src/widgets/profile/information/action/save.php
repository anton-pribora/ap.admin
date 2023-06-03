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

$props[] = ['Тип профиля', $data['type'] ?? '', [$record, 'type'], [$record, 'setType'], $defaultFormat];
$props[] = ['name', $data['name'] ?? '', [$record, 'name'], [$record, 'setName'], $defaultFormat];

$changes = [];

foreach ($props as [$prop, $new, $getter, $setter, $format]) {
    $old = $getter();

    if (is_array($old) || is_array($new)) {
        $diff = \Data\ArrayUtils::calcChanges((array) $old, (array) $new);

        if ($diff) {
            $setter($new);
            $changes[] = 'Изменено поле «<b>' . $prop . '</b>»: <ul><li>' . join('</li><li>', \Data\ArrayUtils::changesToTextArray($diff)) . '</li></ul>';
        }
    } elseif ($old != $new) {
        $setter($new);
        $changes[] = sprintf('Изменено поле «<b>%s</b>»: «%s» => «%s»', $prop, $format($old), $format($new));
    }
}

if ($changes) {
    $record->save();
    $record->addHistory('В запись <b>' . $record->name() . '</b> внесены изменения: <ul><li>' . join('</li><li>', $changes) . '</li></ul>');
}

$this->include('data.php');
