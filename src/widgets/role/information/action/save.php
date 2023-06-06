<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();

$data       = $this->param('widget_data', [])['data'] ?? [];
$enableEdit = $this->param('role.edit') || $this->param('role.information.edit');

if (!$enableEdit) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$defaultFormat = static fn($v) => $v;

// Изменяемые свойства
$props = [];

//$props[] = ['Коротая метка', $data['tag'] ?? '', [$record, 'tag'], [$record, 'setTag'], $defaultFormat];
$props[] = ['Название', $data['name'] ?? '', [$record, 'name'], [$record, 'setName'], $defaultFormat];
$props[] = ['Описание', $data['comment'] ?? '', [$record, 'comment'], [$record, 'setComment'], $defaultFormat];
$props[] = ['Права роли', array_filter($data['permissions'] ?? []), [$record, 'permissions'], [$record, 'setPermissions'], $defaultFormat];

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
