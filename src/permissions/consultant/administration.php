<?php

/* @permission.name Администрирование */

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant \Project\Profile */

$consultant = $this->argument(0);

return true;
return $consultant->permissionValueByFile(__FILE__) === true;
