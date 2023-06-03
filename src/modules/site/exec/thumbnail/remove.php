<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $file Project\File */

use Project\FileRepository;

$rmdir = function ($path) {
    if (!(new FilesystemIterator($path))->valid()) {
        rmdir($path);
    }
};

$file = $this->argument();

foreach ($file->thumbnails() as $thumbnail) {
    $path = ExpandPath($thumbnail->path());

    if (is_file($path) || is_link($path)) {
        unlink($path);

        // Удаляем папку файла и папку на уровень выше
        $rmdir(dirname($path));
        $rmdir(dirname($path, 2));
    }
}

$path = $file->fullPath();

if (file_exists($path)) {
    unlink($path);

    // Удаляем папку файла и папку на уровень выше
    $rmdir(dirname($path));
    $rmdir(dirname($path, 2));
}

FileRepository::drop($file);

return true;
