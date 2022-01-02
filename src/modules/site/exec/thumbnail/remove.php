<?php

use Site\File;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $parent Site\Item */

$parent = $this->argument();

if ($parent->thumbnailId()) {
    $thumbnail = File::getInstance($parent->thumbnailId());
    
    $this->execute('attachment/remove.php', $thumbnail);
    
    $parent->setThumbnailId(null);
    $parent->meta()->save();
}