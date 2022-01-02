<?php

Module('widgets')->executeOnce('view/init.php');

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $api \Site\Consultant\ConsultantCommentsAPI */

$api = $this->argument()->consultantCommentsAPI();
$enableEdit = $this->param('comments.edit');

RequireLib('plankton');

Layout()->append('body.js.code', file_get_contents(__dir('../dist/service.js')));
Layout()->append('body.js.code', 'window.partnerConsultantComments = '. json_encode_array($api->consultantComments()) .';');

if ($enableEdit) {
    $this->include('../dist/edit_dialog.php');
}

$this->execute('../dist/view_form.php', $api, ['enableEdit' => $enableEdit] + $this->paramList());