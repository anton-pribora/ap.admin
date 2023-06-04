<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$editable = $this->param('profile.edit') || $this->param('profile.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на удаление', 'forbidden');
}

// Project\ProfileRepository::drop($record);

$record->setDel(1);
$record->save();

$record->addHistory('Пользователь #' . $record->id() . ' «<b>' . $record->name() . '</b>» был удалён');

AddSessionAlert("Пользователь «{$record->name()}» был удалён");

ReturnJson([
    'url' => ShortUrl($record->urlAsset('url.view'), ['profile_id' => null])
]);
