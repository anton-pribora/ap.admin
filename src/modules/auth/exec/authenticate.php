<?php

use Site\Consultant;
use Site\LoginRepository;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */
/* @var $password string */

$login    = $this->argument(0);
$password = $this->argument(1);
$auth     = false;

if ($login && $password) {
    $identity = Identity();

    // Тестовый логин и пароль
    if ($login === 'test' && $password === '123') {
        $identity->setEntry('consultant', 1, 'Test');
        $auth = true;
    }

    if ($auth) {
        Session()->start();
        Session()->setIdentity($identity);
    }
}

return $auth;
