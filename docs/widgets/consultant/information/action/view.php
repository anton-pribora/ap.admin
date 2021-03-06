<?php

Module('widgets')->executeOnce('view/init.php');

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();
$enableEdit = $this->param('consultant.edit') || $this->param('consultant.information.edit');

RequireLib('plankton');
Widget('info::enable');

if ($enableEdit) {
    $this->include('../dist/edit_dialog.php');
    $this->include('../dist/login_dialog.php');
}

Layout()->append('body.js.code', file_get_contents(__dir('../dist/view_controller.js')));
Layout()->append('body.js.code', file_get_contents(__dir('../dist/service.js')));

Layout()->append('body.js.code', 'window.consultantInformation = '. json_encode_array($this->include('encodeItem.php')) .';');
Layout()->append('body.js.code', 'window.consultantId = '. json_encode_array(Identity()->consultant()->id()) .';');

$this->execute('../dist/view_form.php', $consultant, ['enableEdit' => $enableEdit] + $this->paramList());