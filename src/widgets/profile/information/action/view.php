<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$enableEdit = $this->param('profile.edit') || $this->param('profile.information.edit');
$enableRemove = $this->param('profile.remove') || $enableEdit;

$this->execute('../dist/view_form.php', $record, ['enableEdit' => $enableEdit, 'enableRemove' => $enableRemove] + $this->paramList());

Layout()->append('body.js.code', file_get_contents(__dir('../dist/store.js')));
Layout()->append('body.js.code', "store.state.profileInformation.data = " . json_encode_array($this->include('encodeData.php')) . ';');
