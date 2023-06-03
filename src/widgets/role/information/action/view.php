<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();

$enableEdit = $this->param('role.edit') || $this->param('role.information.edit');

$this->execute('../dist/view_form.php', $record, ['enableEdit' => $enableEdit] + $this->paramList());

Layout()->append('body.js.code', file_get_contents(__dir('../dist/store.js')));
Layout()->append('body.js.code', "store.state.roleInformation.data = " . json_encode_array($this->include('encodeData.php')) . ';');
