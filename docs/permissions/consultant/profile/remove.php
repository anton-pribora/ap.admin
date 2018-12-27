<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */
/* @var $profile Site\Consultant */

$consultant = $this->argument();
$profile    = $this->argument(1);

if ($profile->isDeleted()) {
    return false;
}

if ($consultant->id() == $profile->id()) {
    return false;
}

if ($consultant->hasRole('admin')) {
    return true;
}

return false;