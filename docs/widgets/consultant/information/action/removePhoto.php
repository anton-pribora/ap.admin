<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant   = $this->argument();
$data     = $this->param('widget_data', []);
$item     = $data['item'] ?? [];
$editable = $this->param('consultant.edit') || $this->param('consultant.information.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

Module('site')->execute('thumbnail/remove.php', $consultant);

ReturnJson(['item' => $this->include('encodeItem.php')]);