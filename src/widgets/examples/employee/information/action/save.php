<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('examples.employee.edit') || $this->param('examples.employee.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$record->setName($data['name'] ?? '');  // ФИО
$record->setPost($data['post'] ?? '');  // Должность
$record->setResponsibilities($data['responsibilities'] ?? '');  // Обязанности

$record->save();

$this->include('data.php');
