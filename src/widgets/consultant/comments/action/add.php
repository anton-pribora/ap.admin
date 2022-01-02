<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $api \Site\Consultant\ConsultantCommentsAPI */

$api = $this->argument()->consultantCommentsAPI();

$data     = $this->param('widget_data', []);
$item     = $data['item'] ?? [];
$editable = $this->param('comments.edit');

$consultant = Identity()->consultant();

if (empty($item)) {
    ReturnJsonError('No data to save', 'empty');
}

if (!$editable) {
    ReturnJsonError('You do not have permission to edit this data', 'forbidden');
}

$row = $api->addNewConsultantComment();
$row->setConsultantId($consultant->id());
$row->setText($item['text'] ?? '');

$api->saveConsultantComments();

ReturnJson(['item' => $row]);