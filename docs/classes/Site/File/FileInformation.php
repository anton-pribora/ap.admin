<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site\File;

use Data\BasicData;

class FileInformation extends BasicData
{
    public function hasThumbnail($size)
    {
        return isset($this->data['thumbnails'][$size]);
    }
    
    public function setThumbnail($size, $path, $width, $height)
    {
        if (!isset($this->data['thumbnails'])) {
            $this->data['thumbnails'] = [];
        }
        
        $this->data['thumbnails'][$size] = [
            'path'   => $path,
            'width'  => $width,
            'height' => $height,
        ];
    }
    
    public function thumbnail($size)
    {
        return $this->data['thumbnails'][$size] ?? [];
    }
    
    public function thumbnails()
    {
        return $this->data['thumbnails'] ?? [];
    }
    
    public function name()
    {
        return $this->data['name'] ?? '';
    }

    public function setName($value)
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function guid()
    {
        return $this->data['guid'] ?? '';
    }

    public function setGuid($value)
    {
        $this->data['guid'] = $value;
        return $this;
    }

    public function mimeType()
    {
        return $this->data['mimeType'] ?? '';
    }

    public function setMimeType($value)
    {
        $this->data['mimeType'] = $value;
        return $this;
    }

    public function path()
    {
        return $this->data['path'] ?? '';
    }

    public function setPath($value)
    {
        $this->data['path'] = $value;
        return $this;
    }

    public function group()
    {
        return $this->data['group'] ?? '';
    }

    public function setGroup($value)
    {
        $this->data['group'] = $value;
        return $this;
    }
}
