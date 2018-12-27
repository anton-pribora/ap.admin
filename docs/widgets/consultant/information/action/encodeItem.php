<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();

$info = $consultant->info();

return [
    'id'           => $consultant->id(),
    'login'        => $info->login(),
    'first_name'   => $info->firstName(),
    'last_name'    => $info->lastName(),
    'display_name' => $consultant->name(),
    'email'        => $info->email(),
    'skype'        => $info->skype(),
    'phone'        => $info->phone(),
    'post'         => $info->post(),
    'thumbnail'    => $consultant->thumbnail('medium'),
    'source'       => $consultant->thumbnail('source'),
    'role' => [
        'id'       => $info->roleId(),
        'name'     => $info->roleName(),
        'editable' => $this->param('consultant.can_change_role'),
    ],
];