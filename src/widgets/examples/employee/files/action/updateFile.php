<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

use Project\FileRepository;

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('examples.employee.edit') || $this->param('examples.employee.files.edit');

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

$file->setName($name);
$file->setMeta('comment', $data['comment'] ?? '');
$file->setMime($data['mime'] ?? '');

$file->save();

ReturnJson(['data' => $this->execute('encodeData.php', $file)]);
