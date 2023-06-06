<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();

$enableEdit   = $this->param('role.edit') || $this->param('role.information.edit');
$enableRemove = $this->param('role.remove') || $this->param('role.information.remove');

$this->execute('../dist/view_form.php', $record, ['enableEdit' => $enableEdit, 'enableRemove' => $enableRemove] + $this->paramList());

Layout()->append('body.js.code', file_get_contents(__dir('../dist/store.js')));
Layout()->append('body.js.code', "store.state.roleInformation.data = " . json_encode_array($this->include('encodeData.php')) . ';');
