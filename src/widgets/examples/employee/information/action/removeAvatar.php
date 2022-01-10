<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('examples.employee.edit') || $this->param('examples.employee.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

if ($record->avatar()->id()) {
    Module('site')->execute('thumbnail/remove.php', $record->avatar());
}

$record->setAvatar(new \Project\File());
$record->save();

$this->include('data.php');
