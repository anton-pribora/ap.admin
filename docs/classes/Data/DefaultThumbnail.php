<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

use Interfaces\Data\ThumbnailInterface;

class DefaultThumbnail implements ThumbnailInterface, \JsonSerializable
{
    private $size;
    
    public function __construct($size = 'thumbnail')
    {
        $this->size = $size;
    }
    
    /**
     * {@inheritDoc}
     * @see \Interfaces\Data\ThumbnailInterface::width()
     */
    public function width()
    {
        return Config()->get("thumbnail.user.width");
    }

    /**
     * {@inheritDoc}
     * @see \Interfaces\Data\ThumbnailInterface::height()
     */
    public function height()
    {
        return Config()->get("thumbnail.user.height");
    }

    /**
     * {@inheritDoc}
     * @see \Interfaces\Data\ThumbnailInterface::url()
     */
    public function url()
    {
        return Config()->get("thumbnail.user.url");
    }
    
    /**
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [
            'url'    => $this->url(),
            'width'  => $this->width(),
            'height' => $this->height(),
        ];
    }
}