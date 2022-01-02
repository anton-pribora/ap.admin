<?php

use Site\File;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $parent Site\Item */

$parent = $this->param('parent');
$source = $this->param('path');
$name   = $this->param('name');
$mime   = $this->param('mime');
$group  = $this->param('group', 'attachment');

$file = new File();
$file->info()->setName($name);
$file->info()->setMimeType($mime);
$file->info()->setGroup($group);
$file->setParentItemId($parent->id());

$file->makePath();

$dest   = $file->fullPath();
$folder = dirname($dest);

if (!file_exists($folder)) {
    if (!mkdir($folder, 0755, true)) {
        return false;
    }
}

if (!copy($source, $dest)) {
    return false;
}

chmod($dest, 0644);

$file->save();
$file->meta()->save();

return $file;