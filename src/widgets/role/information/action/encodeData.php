<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();
$recordPermissions = $record->permissions();

$permissions = [];

foreach (Module('permissions')->execute('list') as $permission => $data) {
    $permissions[$permission] = $recordPermissions[$permission] ?? false;
}

return [
    'id'          => $record->id(),
    'tag'         => $record->tag(),
    'name'        => $record->name(),
    'comment'     => $record->comment(),
    'permissions' => $permissions ?: new stdClass(),
];
