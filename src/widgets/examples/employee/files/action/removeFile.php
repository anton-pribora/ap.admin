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

Module('site')->execute('attachment/remove.php', $file);

ReturnJson(true);
