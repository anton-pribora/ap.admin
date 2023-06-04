<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$roles = [];

foreach (\Project\RoleRepository::findMany([]) as $role) {
    $roles[$role->tag()] = [
        'name'    => $role->name(),
        'comment' => $role->comment(),
        'checked' => $record->hasRole($role->tag())
    ];
}

return [
    'roles' => $roles,
];
