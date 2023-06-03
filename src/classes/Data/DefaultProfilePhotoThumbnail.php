<?php

namespace Data;

class DefaultProfilePhotoThumbnail extends Thumbnail
{
    public function __construct()
    {
        parent::__construct('/img/profile.webp', 192, 192);
    }
}
