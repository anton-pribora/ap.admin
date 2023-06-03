<?php

namespace Data;

class Thumbnail implements \JsonSerializable
{
    private $width;
    private $height;
    private $path;

    public function __construct($path, $width = NULL, $height = NULL)
    {
        $this->path   = $path;
        $this->width  = $width;
        $this->height = $height;
    }

    public function width()
    {
        return $this->width;
    }

    public function height()
    {
        return $this->height;
    }

    public function path()
    {
        return $this->path;
    }

    public function shortUrl()
    {
        return (string) ShortUrl($this->path, [], true);
    }

    public function fullPath()
    {
        return ExpandPath($this->path);
    }

    public function jsonSerialize(): array
    {
        return [
            'url'    => $this->shortUrl(),
            'width'  => $this->width(),
            'height' => $this->height(),
        ];
    }
}
