<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$data     = $this->param('widget_data', []);
$item     = $data['item'] ?? [];
$editable = $this->param('examples.employee.edit') || $this->param('examples.employee.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$record->setId($item['id'] ?? '');  // Идентификатор записи
$record->setName($item['name'] ?? '');  // ФИО
$record->setPost($item['post'] ?? '');  // Должность
$record->setResponsibilities($item['responsibilities'] ?? '');  // Обязанности

$record->save();

ReturnJson(['item' => $this->include('encodeItem.php')]);
