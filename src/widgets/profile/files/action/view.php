<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$enableEdit = $this->param('profile.edit') || $this->param('profile.files.edit');

$this->execute('../dist/view_form.php', $record, ['enableEdit' => $enableEdit] + $this->paramList());

Layout()->append('body.js.code', file_get_contents(__dir('../dist/store.js')));
Layout()->append('body.js.code', "store.state.profileFiles.list = " . json_encode_array($this->include('encodeList.php')) . ';');
