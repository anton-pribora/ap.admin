<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $file Project\File */

use Project\FileRepository;

$file = $this->argument();

foreach ($file->thumbnails() as $thumbnail) {
    $path = ExpandPath($thumbnail->path());

    if (file_exists($path) || is_link($path)) {
        unlink($path);
    }
}

$path = $file->fullPath();

if (file_exists($path)) {
    unlink($path);
}

FileRepository::drop($file);

return true;
