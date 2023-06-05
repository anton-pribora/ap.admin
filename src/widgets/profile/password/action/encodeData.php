<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$credential = $record->credential();

return [
    'login'      => $credential->login(),
    'last_usage' => [
        'raw'       => $credential->lastLoginTime(),
        'formatted' => $credential->lastLoginTime() ? intl_date('d MMM y HH:mm', $credential->lastLoginTime()) : null,
    ]
];
