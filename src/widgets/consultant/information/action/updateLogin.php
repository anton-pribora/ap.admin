<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();
$data       = $this->param('widget_data', []);
$item       = $data['item'] ?? [];
$editable   = $this->param('consultant.edit') || $this->param('consultant.information.edit');

$permitChangeRole = $this->param('consultant.can_change_role');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$login    = trim($item['login'] ?? '');
$password = trim($item['password'] ?? '');

$errors = Module('auth')->execute('validate_credentials.php', [
    'login'    => $login,
    'password' => $password ?: '123456',
    'parentId' => $consultant->id(),
]);

if ($errors) {
    ReturnJsonError(current($errors), 'invalid_credentials', $errors);
}

$consultant->info()->setLogin($login);

if ($password) {
    Module('auth')->execute('set_password.php', $consultant, $password);
}

$consultant->save();
$consultant->meta()->save();

ReturnJson(['item' => $this->include('encodeItem.php')]);