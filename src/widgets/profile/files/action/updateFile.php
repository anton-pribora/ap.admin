<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

use Project\FileRepository;

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('profile.edit') || $this->param('profile.files.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$fileId = $data['id'];

if (empty($fileId)) {
    ReturnJsonError('Не указан идентификатор файла', 'null_id');
}

$file = FileRepository::findOne([
    'parentType' => $record::tableName(),
    'parentId'   => $record->id() ?: -1,
    'id'         => $fileId,
]);

if (empty($file->id())) {
    ReturnJsonError('Запись файла не найдена в базе данных', 'id_not_found');
}

$name = trim($data['name'] ?? '');

if (empty($name)) {
    ReturnJsonError('Не указано название файла', 'invalid_data');
}

$defaultFormat = static fn($v) => $v;

// Изменяемые свойства
$props = [];

$props[] = ['Имя'        , $name                 , [$file, 'name'   ], [$file, 'setFirstName'      ], $defaultFormat];
$props[] = ['Комментарий', $data['comment'] ?? '', [$file, 'comment'], [$file, 'setComment'        ], $defaultFormat];

$changes = [];

$oldFileName = $file->name();

foreach ($props as [$prop, $new, $getter, $setter, $format]) {
    $old = $getter();

    if ($old != $new) {
        $setter($new);
        $changes[] = sprintf('«<b>%s</b>»: «%s» => «%s»', $prop, $format($old), $format($new));
    }
}

if ($changes) {
    $file->save();
    $record->addHistory('В пользователе <b data-profile>' . $record->fullName() . '</b> внесены изменения в файл <b>' . Html($oldFileName) . '</b>: <ul><li>' . join('</li><li>', $changes) . '</li></ul>');
}

$file->save();

ReturnJson(['data' => $this->execute('encodeData.php', $file)]);
