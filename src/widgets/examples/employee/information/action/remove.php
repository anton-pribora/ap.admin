<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$editable = $this->param('examples.employee.edit') || $this->param('examples.employee.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на удаление', 'forbidden');
}

Project\Examples\EmployeeRepository::drop($record);

AddSessionAlert("Сотрудник «{$record->name()}» был удалён");

ReturnJson(true);
