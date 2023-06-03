<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('profile.edit') || $this->param('profile.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

if ($record->photo()->id()) {
    Module('site')->execute('thumbnail/remove.php', $record->photo());
}

if ($record->photoId()) {
    $message = 'В пользователя <b data-profile>' . $record->fullName() . '</b> внесены изменения: <ul><li><b>Удалена фотография</b></li></ul>';

    $record->setPhotoId(null);
    $record->save();

    $record->addHistory($message, ['file_id' => $record->photoId()]);
}

$this->include('data.php');
