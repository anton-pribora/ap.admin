<?php

/* @var $this ApCode\Executor\RuntimeInterface */

$parentType = $this->param('parentType');
$parentId   = $this->param('parentId');
$source     = $this->param('path');
$name       = $this->param('name');
$mime       = $this->param('mime');
$subFolder  = $this->param('subFolder');

$file = new Project\File();
$file->setName($name);
$file->setMime($mime);
$file->setParentType($parentType);
$file->setParentId($parentId);

$file->makePath($subFolder);

$dest   = $file->fullPath();
$folder = dirname($dest);

if (!file_exists($folder)) {
    if (!mkdir($folder, 0755, true)) {
        return [false, 'Не удалось создать папку ' . $folder];
    }
}

if (!copy($source, $dest)) {
    return [false, 'Не удалось скопировать файл из ' . $source];
}

$file->setSize(filesize($file->fullPath()));
$file->save();

return [$file, null];
