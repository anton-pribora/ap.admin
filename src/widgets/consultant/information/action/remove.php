<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();
$data     = $this->param('widget_data', []);
$item     = $data['item'] ?? [];
$editable = $this->param('consultant.edit') || $this->param('consultant.information.edit');

$permitRemoveProfile = $this->param('consultant.can_remove');

if (!$permitRemoveProfile) {
    ReturnJsonError('У вас нет прав для удаления пользователя', 'forbidden');
}

AddSessionAlert('Пользователь "'. $consultant->name() .'" был удалён', 'success');

$info = $consultant->info();

// Меняем логин и пароль удаляемого пользователя, дабы пользователь не смущал нас своим присутствием
$info->setLogin(sha1(uniqid('login')));
$info->setPassword(sha1(uniqid('password')));

$consultant->setDel(1);
$consultant->save();
$consultant->meta()->save();

ReturnJson(['result' => true]);