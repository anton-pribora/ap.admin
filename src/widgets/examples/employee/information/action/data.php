<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

ReturnJson(['data' => $this->include('encodeData.php')]);
