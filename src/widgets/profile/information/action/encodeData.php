<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

return [
    'id'   => $record->id(),
    'name' => [
        'first'  => $record->firstName(),
        'last'   => $record->lastName(),
        'middle' => $record->middleName(),
        'full'   => $record->fullName(),
    ],
    'post'     => $record->post(),
    'contacts' => $record->contactsRaw(),
    'comment'  => $record->comment(),
];
