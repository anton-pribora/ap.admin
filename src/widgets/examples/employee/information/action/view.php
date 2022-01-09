<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

$enableEdit = $this->param('examples.employee.edit') || $this->param('examples.employee.information.edit');

$this->execute('../dist/view_form.php', $record, ['enableEdit' => $enableEdit] + $this->paramList());

Layout()->append('body.js.code', file_get_contents(__dir('../dist/store.js')));
Layout()->append('body.js.code', "store.state.examplesEmployeeInformation.data = " . json_encode_array($this->include('encodeItem.php')) . ';');