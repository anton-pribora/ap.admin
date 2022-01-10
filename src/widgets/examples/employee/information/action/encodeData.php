<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();

if ($record->avatar()->id()) {
    $avatar = ShortUrl($record->avatar()->getThumbnail('small')->path(), [], true);
} else {
    $avatar = false;
}

return [
    'id'               => $record->id(),
    'name'             => $record->name(),
    'post'             => $record->post(),
    'responsibilities' => $record->responsibilities(),
    'avatar'           => $avatar,
];
