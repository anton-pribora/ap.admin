<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Project\Profile */
/* @var $record Project\Profile */

$consultant = $this->argument(0);
$record = $this->argument(1);

return $this->include(__dir('edit.php'));
