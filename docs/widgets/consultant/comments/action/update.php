<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $api \Site\Consultant\ConsultantCommentsAPI */

$api = $this->argument()->consultantCommentsAPI();

$data     = $this->param('widget_data', []);
$item     = $data['item'] ?? [];
$editable = $this->param('comments.edit');

if (empty($item['id'])) {
    ReturnJsonError('Record not found', 'empty_id');
}

if (!$editable) {
    ReturnJsonError('You do not have permission to edit this data', 'forbidden');
}

$row = $api->findConsultantCommentById($item['id'] ?? -999);

if (!$row) {
    ReturnJsonError('Record not found', 'not found');
}

$row->setConsultantId($item['consultant']['id'] ?? '');
$row->setText($item['text'] ?? '');
$row->setDate($item['date'] ?? '');

$api->saveConsultantComments();

ReturnJson(['item' => $row]);