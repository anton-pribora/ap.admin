<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

return [
    'id'               => $record->id(),
    'name'             => $record->name(),
    'post'             => $record->post(),
    'responsibilities' => $record->responsibilities(),
];
