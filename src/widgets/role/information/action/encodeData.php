<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->argument();

return [
    'id'      => $record->id(),
    'tag'     => $record->tag(),
    'name'    => $record->name(),
    'comment' => $record->comment(),
];
