<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Project\Profile */
/* @var $record Project\Role */

$consultant = $this->argument(0);
$record = $this->argument(1);

return $this->include(ExpandPath('@permissions/consultant/administration.php'));
