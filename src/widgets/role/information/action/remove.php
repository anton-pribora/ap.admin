<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();

$editable = $this->param('role.edit') || $this->param('role.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на удаление', 'forbidden');
}

// Project\RoleRepository::drop($record);

$record->setDel(1);
$record->save();

$record->addHistory('Запись <b>' . $record->name() . '</b> была удалёна');

AddSessionAlert("Запись «{$record->name()}» была удалена");

ReturnJson(true);
