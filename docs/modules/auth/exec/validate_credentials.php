<?php

use Site\LoginRepository;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */
/* @var $password string */

$login    = $this->param('login');
$password = $this->param('password');
$parentId = $this->param('parentId');

$errors = [];

if (mb_strlen($login) < 3) {
    $errors[] = 'Логин не может быть меньше трёх символов';
}

if (mb_strlen($password) < 4) {
    $errors[] = 'Пароль не может быть меньше четырёх символов';
}

if ($login) {
    $parent = LoginRepository::findOne(['login' => $login, 'id!=' => $parentId]);
    
    if ($parent) {
        $errors[] = 'Логин уже используется, придумайте другой';
    }
}

return $errors;