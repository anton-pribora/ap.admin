<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('profile.edit') || $this->param('profile.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$file = current($_FILES) ?? [];
$error = $file['error'] ?? 4;

if ($error) {
    ReturnJsonError(upload_error_description($error), 'upload_error');
}

[$item, $error] = Module('site')->execute('thumbnail/upload.php', [
    'parentType' => $record::tableName(),
    'parentId'   => $record->id(),
    'path'       => $file['tmp_name'],
    'name'       => $file['name'],
    'mime'       => $file['type'],
    'subFolder'  => 'photo',
]);

if ($error) {
    ReturnJsonError($error, 'upload_error');
}

if ($record->photo()->id()) {
    Module('site')->execute('thumbnail/remove.php', $record->photo());
}

$record->setPhotoId($item->id());
$record->save();

$prefix = 'В пользователя <b data-profile>' . $record->fullName() . '</b> внесены изменения: ';
$record->addHistory($prefix . sprintf('<ul><li>Загружена фотография #%s <b>%s</b></li></ul>', $item->id(), $item->name()), ['file_id' => $item->id()]);

ReturnJson(true);
