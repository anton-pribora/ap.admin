<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

return [
    'id'   => $record->id(),
    'type' => $record->type(),
    'name' => $record->name(),
];
