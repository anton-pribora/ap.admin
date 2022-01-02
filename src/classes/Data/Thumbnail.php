<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

use Interfaces\Data\ThumbnailInterface;

class Thumbnail implements ThumbnailInterface, \JsonSerializable
{
    private $width;
    private $height;
    private $url;

    public function __construct($url, $width = NULL, $height = NULL)
    {
        $this->url    = $url;
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * {@inheritDoc}
     * @see \Interfaces\Data\ThumbnailInterface::width()
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * {@inheritDoc}
     * @see \Interfaces\Data\ThumbnailInterface::height()
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * {@inheritDoc}
     * @see \Interfaces\Data\ThumbnailInterface::url()
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize(): array
    {
        return [
            'url'    => $this->url(),
            'width'  => $this->width(),
            'height' => $this->height(),
        ];
    }
}
