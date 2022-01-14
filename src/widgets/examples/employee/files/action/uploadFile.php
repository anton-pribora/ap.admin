<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('examples.employee.edit') || $this->param('examples.employee.files.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$file = current($_FILES) ?? [];
$error = $file['error'] ?? 4;

if ($error) {
    ReturnJsonError(upload_error_description($error), 'upload_error');
}

[$attachment, $error] = Module('site')->execute('attachment/upload.php', [
    'parentType' => $record::tableName(),
    'parentId'   => $record->id(),
    'path'       => $file['tmp_name'],
    'name'       => $file['name'],
    'mime'       => $file['type'],
    'group'      => 'attachment'
]);

if ($error) {
    ReturnJsonError($error, 'upload_error');
}

ReturnJson(true);
