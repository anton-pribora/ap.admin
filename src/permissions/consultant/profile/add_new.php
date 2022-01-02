<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();

if ($consultant->hasRole('admin')) {
    return true;
}

return false;