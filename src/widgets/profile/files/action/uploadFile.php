<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('profile.edit') || $this->param('profile.files.edit');

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
    'subFolder'  => 'profile_files',
]);

if ($error) {
    ReturnJsonError($error, 'upload_error');
}

$record->addHistory('К пользователю <b data-profile>' . $record->fullName() . '</b> загружен файл <b>' . Html($file['name']) . '</b>');

ReturnJson(true);
