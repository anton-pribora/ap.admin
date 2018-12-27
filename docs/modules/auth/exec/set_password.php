<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */
/* @var $password string */

$consultant = $this->argument(0);
$password   = $this->argument(1);

$hash = password_hash($password, PASSWORD_DEFAULT);

$consultant->info()->setPassword($hash);