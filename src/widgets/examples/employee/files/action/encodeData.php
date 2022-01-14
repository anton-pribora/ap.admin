<?php
/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\File */

$record = $this->argument();

return [
    'id'       => $record->id(),
    'name'     => $record->name(),
    'url'      => [
        'view' => $record->urlAsset('url.view')
    ],
    'date'     => $record->createdAt(),
    'size'     => [
        'raw'       => $record->size(),
        'formatted' => formatBytes($record->size())
    ],
    'mime'     => $record->mime(),
    'comment'  => $record->meta('comment', ''),
];
