<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant   = $this->argument();
$data     = $this->param('widget_data', []);
$item     = $data['item'] ?? [];
$editable = $this->param('consultant.edit') || $this->param('consultant.information.edit');

ReturnJson(['item' => $this->include('encodeItem.php')]);