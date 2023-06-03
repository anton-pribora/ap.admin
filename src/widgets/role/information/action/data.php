<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();

ReturnJson(['data' => $this->include('encodeData.php')]);
