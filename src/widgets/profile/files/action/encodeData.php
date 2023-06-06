<?php
/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\File */

$record = $this->argument();

$mimeToIcon = function ($mime) {
    return match (true) {
        (bool) preg_match('/pdf/', $mime) => '<i class="bi bi-file-pdf text-danger me-1"></i>',
        (bool) preg_match('/word/', $mime) => '<i class="bi bi-file-word text-primary me-1"></i>',
        (bool) preg_match('/excel|spreadsheet/', $mime) => '<i class="bi bi-file-excel text-success me-1"></i>',
        (bool) preg_match('/image/', $mime) => '<i class="bi bi-file-earmark-image text-muted me-1"></i>',
        default => '<i class="bi bi-file-earmark-bar-graph text-muted me-1"></i>'
    };
};

return [
    'id'   => $record->id(),
    'name' => $record->name(),
    'url'  => [
        'view' => $record->urlAsset('url.view'),
    ],
    'size' => [
        'raw'       => $record->size(),
        'formatted' => formatBytes($record->size())
    ],
    'mime' => [
        'raw'  => $record->mime(),
        'icon' => $mimeToIcon($record->mime()),
    ],
    'comment'   => $record->comment(),
    'createdAt' => [
        'raw'       => $record->createdAt(),
        'formatted' => intl_date('d MMMM y, HH:mm:ss', $record->createdAt())
    ],
];
