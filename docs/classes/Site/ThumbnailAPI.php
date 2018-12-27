<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

use Data\BasicData;
use Data\Thumbnail;

class ThumbnailAPI extends BasicData
{
    public function hasThumbnail()
    {
        return $this->thumbnailId() > 0;
    }
    
    public function getThumbnail($size)
    {
        $item = File::getInstance($this->thumbnailId());
        
        if ($item->id()) {
            $row = $item->info()->thumbnail($size);
            
            if ($row) {
                return new Thumbnail(ExpandUrl($row['path']), $row['width'], $row['height']);
            }
        }
        
        return null;
    }
    
    public function thumbnailId()
    {
        return $this->data['thumbnail_id'] ?? null;
    }
    
    public function setThumbnailId($id)
    {
        if ($id) {
            $this->data['thumbnail_id'] = $id;
        } else {
            unset($this->data['thumbnail_id']);
        }
        
        return $this;
    }
}