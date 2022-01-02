<?php

use ApCode\File\Image;
use Site\File;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $parent Site\Item */
/* @var $file Site\File */

$parent = $this->param('parent');
$source = $this->param('path');
$name   = $this->param('name');
$mime   = $this->param('mime');
$group  = $this->param('group', 'thumbnail');

$image = new Image($source);

if (!$image->isValidImage()) {
    return false;
}

if (empty($mime)) {
    $mime = $image->mimeType();
}

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

$sizes = [
    'small'  => [100, true],
    'medium' => [350, false],
    'big'    => [600, false],
    'source' => [PHP_INT_MAX, false],
];

$image = new Image($file->fullPath());
$info  = $file->info();
$guid  = $info->guid();

$fileName = mb_substr($guid, 0, 2) .'/'. mb_substr($guid, 2);
$fileExtension = $image->imageExtention();

$relative = function ($source, $target) {
    $pos = 0;
    $eq  = 0;
    
    while (($pos = strpos($source, '/', $pos + 1)) !== false) {
        if (substr_compare($source, $target, 0, $pos) === 0) {
            $eq = $pos + 1;
        }
    }
    
    $source = substr($source, $eq);
    $target = substr($target, $eq);
    
    return preg_replace('~[^/]+/~', '../', dirname($target) . "/") . $source;
};

foreach ($sizes as $sizeName => list($size, $crop)) {
    $thumbnail = "@thumbnails/{$fileName}-{$sizeName}{$fileExtension}";
    $fullPath  = ExpandPath($thumbnail);
    $folder    = dirname($fullPath);
    
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
    }

    if ($crop) {
        $newImg = $image->resizeAndCrop($size, $size, $fullPath);
        
        $width  = $newImg->width();
        $height = $newImg->height();
    } elseif ($image->width() > $size || $image->height() > $size) {
        $newImg = $image->inscribe($size, $size, $fullPath);
        
        $width  = $newImg->width();
        $height = $newImg->height();
    } else {
        // Create a symlink to original
        if (!file_exists($fullPath)) {
            if (symlink($relative($file->fullPath(), $fullPath), $fullPath)) {
                // good!
            } else {
                copy($file->fullPath(), $fullPath);
            }
        }
        
        $width  = $image->width();
        $height = $image->height();
    }
    
    $info->setThumbnail($sizeName, $thumbnail, $width, $height);
}

$image->close();

$file->save();
$file->meta()->save();

$parent->setThumbnailId($file->id());
$parent->meta()->save();

return $file;