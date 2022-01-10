<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('examples.employee.edit') || $this->param('examples.employee.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$file = current($_FILES) ?? [];
$error = $file['error'] ?? 4;

if ($error) {
    ReturnJsonError(upload_error_description($error), 'upload_error');
}

if ($record->avatar()->id()) {
    Module('site')->execute('thumbnail/remove.php', $record->avatar());
}

[$thumbnail, $error] = Module('site')->execute('thumbnail/upload.php', [
    'parentType' => $record::tableName(),
    'parentId'   => $record->id(),
    'path'       => $file['tmp_name'],
    'name'       => $file['name'],
    'mime'       => $file['type'],
    'group'      => 'avatar'
]);

if ($error) {
    ReturnJsonError($error, 'upload_error');
}

$record->setAvatar($thumbnail);
$record->save();

ReturnJson(true);
