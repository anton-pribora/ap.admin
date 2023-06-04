<?php

use ApCode\File\Image;
use Project\File;

/* @var $this ApCode\Executor\RuntimeInterface */

$parentType = $this->param('parentType');
$parentId   = $this->param('parentId');
$source     = $this->param('path');
$name       = $this->param('name');
$mime       = $this->param('mime');
$subFolder  = $this->param('subFolder');

$image = new Image($source);

if (!$image->isValidImage()) {
    return [false, 'Файл не является изображением'];
}

if (empty($mime)) {
    $mime = $image->mimeType();
}

$file = new File();
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

chmod($dest, 0644);

$sizes = [
    'small'  => [100, true],
    'medium' => [400, false],
    'big'    => [900, false],
    'source' => [PHP_INT_MAX, false],
];

$image = new Image($file->fullPath());
$guid  = $file->guid();

$fileName = join('/', [
    mb_substr($guid, 0, 2),
    mb_substr($guid, 2, 2),
    mb_substr($guid, 4)
]);
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

foreach ($sizes as $sizeName => [$size, $crop]) {
    $thumbnail = "@thumbnails/{$fileName}-{$sizeName}{$fileExtension}";
    $fullPath  = ExpandPath($thumbnail);
    $folder    = dirname($fullPath);

    try {
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
            // Create symlink to the original
            if (!file_exists($fullPath)) {
                if (!symlink($relative($file->fullPath(), $fullPath), $fullPath)) {
                    // ... or copy
                    copy($file->fullPath(), $fullPath);
                }
            }

            $width  = $image->width();
            $height = $image->height();
        }
    } catch (Exception | Error $exception) {
        return [false, $exception->getMessage()];
    }

    $file->setThumbnail($sizeName, new \Data\Thumbnail($thumbnail, $width, $height));
}

$image->close();

$file->save();

return [$file, null];
