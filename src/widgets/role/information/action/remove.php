<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();

$enableRemove = $this->param('role.remove') || $this->param('role.information.remove');

if (!$enableRemove) {
    ReturnJsonError('У вас нет прав на удаление', 'forbidden');
}

// Project\RoleRepository::drop($record);

$record->setDel(1);
$record->save();

$record->addHistory('Запись <b>' . $record->name() . '</b> была удалёна');

AddSessionAlert("Запись «{$record->name()}» была удалена");

ReturnJson([
    'url' => ShortUrl($record->urlAsset('url.view'), ['role_id' => null])
]);

