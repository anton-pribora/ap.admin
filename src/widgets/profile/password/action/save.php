<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();
$credential = $record->credential();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('profile.password.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$login           = trim($data['login'] ?? '');
$oldPassword     = $data['oldPassword'] ?? '';
$newPassword     = $data['newPassword'] ?? '';
$confirmPassword = $data['confirmPassword'] ?? '';

$changes = [];

if ($editable === 'full') {
    // Если логин уже был создан
    if ($credential->login()) {
        if ($login != $credential->login()) {
            // Проверяем логин
            if (empty($login)) {
                ReturnJsonError('Укажите логин', 'empty_login');
            }

            // Проверяем логин на уникальность
            if (\Project\ProfileCredentialRepository::findOne(['login' => $login, 'id!=' => $record->id()])) {
                ReturnJsonError('Логин уже используется', 'ambiguous_login');
            }

            $changes[] = sprintf('«<b>Логин</b>»: «%s» => «%s»', $credential->login(), $login);
            $credential->setLogin($login);
        }
    } else {
        // Новый логин
        if (empty($login)) {
            ReturnJsonError('Укажите логин', 'empty_login');
        }

        // Проверяем логин на уникальность
        if (\Project\ProfileCredentialRepository::findOne(['login' => $login])) {
            ReturnJsonError('Логин уже используется', 'ambiguous_login');
        }

        $changes[] = sprintf('Установлен «<b>Логин</b>»: «%s»', $login);
        $credential->setLogin($login);
    }

    if ($newPassword) {
        if ($newPassword !== $confirmPassword) {
            ReturnJsonError('Подтверждение пароля указано неверно', 'invalid_confirm');
        }

        if (empty($newPassword)) {
            ReturnJsonError('Укажите пароль', 'empty_password');
        }

        $changes[] = sprintf('Установлен новый «<b>Пароль</b>»');
        $credential->setPassword($newPassword);
    }
}

if ($editable === 'partial') {
    if (empty($credential->login())) {
        ReturnJsonError('Неверная учётная запись', 'invalid_credential');
    }

    if (empty($oldPassword)) {
        ReturnJsonError('Введите текущий пароль', 'empty_password');
    }

    if (!$credential->verifyPassword($oldPassword)) {
        ReturnJsonError('Текущий пароль указан неверно', 'invalid_current_password');
    }

    if ($newPassword !== $confirmPassword) {
        ReturnJsonError('Подтверждение пароля указано неверно', 'invalid_confirm');
    }

    if (empty($newPassword)) {
        ReturnJsonError('Укажите пароль', 'empty_password');
    }

    $changes[] = 'Установлен новый «<b>Пароль</b>»';
    $credential->setPassword($newPassword);
}

if ($changes) {
    $credential->save();
    $record->addHistory('В пользователя <b data-profile>' . $record->fullName() . '</b> внесены изменения: <ul><li>' . join('</li><li>', $changes) . '</li></ul>');
}

$this->include('data.php');
