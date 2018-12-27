<?php

use Site\ConsultantRepository;

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

$info = $consultant->info();

$info->setFirstName($item['first_name'] ?? '');
$info->setLastName($item['last_name'] ?? '');
$info->setEmail($item['email'] ?? '');
$info->setSkype($item['skype'] ?? '');
$info->setPhone($item['phone'] ?? '');
$info->setPost($item['post'] ?? '');

$newRoleId = $item['role']['id'] ?? '';

if ($info->roleId() != $newRoleId) {
    if (!$permitChangeRole) {
        ReturnJsonError('Вы не можете менять роль', 'forbidden');
    }
    
    // Проверяем, много ли останется админов, если пользоватлю поменять роль
    if ($info->roleId() == 'admin' && !ConsultantRepository::findOne(['id!=' => $consultant->id(), 'roleId' => 'admin'])) {
        ReturnJsonError('Похоже, что это единственный администратор. Давайте не будем менять роль, а то будет, как в прошлый раз... Хорошо?', 'nooooo');
    }
    
    $consultant->setRoleId($newRoleId);
}

$consultant->save();
$consultant->meta()->save();

ReturnJson(['item' => $this->include('encodeItem.php')]);