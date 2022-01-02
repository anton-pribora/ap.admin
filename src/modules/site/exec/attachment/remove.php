<?php

use Site\FileRepository;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $file Site\File */

$file = $this->argument();

foreach ($file->info()->thumbnails() as $size => $data) {
    $path = $data['path'] ?? '';
    
    if ($path) {
        $path = ExpandPath($path);
        
        if (file_exists($path) || is_link($path)) {
            unlink($path);
        }
    }
}

$path = $file->fullPath();

if (file_exists($path)) {
    unlink($path);
}

FileRepository::drop($file);
