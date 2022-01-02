<?php

use Site\FileRepository;
use Site\File;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $parent Site\Item */

$parent = $this->param('parent');

$oldThumbnailId = $parent->thumbnailId();

$file = $this->include('thumbnail/upload.php');

if ($oldThumbnailId && $file) {
    $oldThumbnail = File::getInstance($oldThumbnailId);
    
    $this->execute('attachment/remove.php', $oldThumbnail);
    FileRepository::drop($oldThumbnail);
}

return $file;