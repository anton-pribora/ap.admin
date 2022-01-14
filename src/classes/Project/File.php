<?php

namespace Project;

use ApCode\Html\Element\A;
use Data\Thumbnail;

/**
 * Файлы
 */
class File extends \ApCode\Billet\AbstractBillet implements \Interfaces\Data\UrlAssetInterface
{
    public function id()
    {
        return $this->data['id'] ?? null;
    }

    public function setId($value)
    {
        $this->data['id'] = $value;
        return $this;
    }

    public function guid()
    {
        return $this->data['guid'] ?? null;
    }

    public function setGuid($value)
    {
        $this->data['guid'] = $value;
        return $this;
    }

    public function group()
    {
        return $this->data['group'] ?? null;
    }

    public function setGroup($value)
    {
        $this->data['group'] = $value;
        return $this;
    }

    public function path()
    {
        return $this->data['path'] ?? null;
    }

    public function setPath($value)
    {
        $this->data['path'] = $value;
        return $this;
    }

    public function name()
    {
        return $this->data['name'] ?? null;
    }

    public function setName($value)
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function parentType()
    {
        return $this->data['parentType'] ?? null;
    }

    public function setParentType($value)
    {
        $this->data['parentType'] = $value;
        return $this;
    }

    public function parentId()
    {
        return $this->data['parentId'] ?? null;
    }

    public function setParentId($value)
    {
        $this->data['parentId'] = $value;
        return $this;
    }

    public function mime()
    {
        return $this->data['mime'] ?? null;
    }

    public function setMime($value)
    {
        $this->data['mime'] = $value;
        return $this;
    }

    public function size()
    {
        return $this->data['size'] ?? null;
    }

    public function setSize($value)
    {
        $this->data['size'] = $value;
        return $this;
    }

    public function meta($path, $default = null)
    {
        $key = strtr($path, ['.' => "']['"]);
        return eval("return \$this->data['meta']['{$key}'] ?? \$default;");
    }

    public function setMeta($path, $value)
    {
        $key = strtr($path, ['.' => "']['"]);
        eval("\$this->data['meta']['{$key}'] = \$value;");
        return $this;
    }

    public function createdAt()
    {
        return $this->data['createdAt'] ?? null;
    }

    public function setCreatedAt($value)
    {
        $this->data['createdAt'] = $value;
        return $this;
    }

    public function getThumbnail($size)
    {
        if (isset($this->data['meta']['thumbnails'][$size])) {
            return new Thumbnail(
                $this->data['meta']['thumbnails'][$size]['path'],
                $this->data['meta']['thumbnails'][$size]['width'],
                $this->data['meta']['thumbnails'][$size]['height']
            );
        }

        return null;
    }

    /**
     * @return Thumbnail[]
     */
    function thumbnails()
    {
        $result = [];

        foreach ($this->data['meta']['thumbnails'] ?? [] as $size => $item) {
            $result[$size] = new Thumbnail(
                $item['path'],
                $item['width'],
                $item['height']
            );
        }

        return $result;
    }

    public function setThumbnail($size, Thumbnail $thumbnail)
    {
        $this->data['meta']['thumbnails'][$size] = [
            'path'   => $thumbnail->path(),
            'width'  => $thumbnail->width(),
            'height' => $thumbnail->height(),
        ];

        return $this;
    }

    public function makeGuid()
    {
        $this->setGuid(substr(sha1(uniqid()), 4, 16));
        return $this;
    }

    public function makePath()
    {
        if (empty($this->guid())) {
            $this->makeGuid();
        }

        $guid = $this->guid();
        $path = join('/', [
            mb_substr($guid, 0, 2),
            mb_substr($guid, 2, 2),
            mb_substr($guid, 4)
        ]);

        $this->setPath("@uploads/$path");

        return $this;
    }

    public function fullPath()
    {
        return ExpandPath($this->path());
    }

    public function urlAsset($key, $params = NULL)
    {
        $param = function($name, $default = null) use(&$params) { return isset($params[$name]) ? $params[$name] : $default; };
        $scope = $param('scope', Config()->get('urlAsset.scope', 'admin'));

        switch ("$scope:$key") {
            case 'admin:url.view' : return UrlAlias()->expand("@root/public/file/{$this->guid()}/{$this->name()}");
            case 'admin:url.download' : return ShortUrl("@root/public/file/{$this->guid()}/{$this->name()}", [], true);
            case 'admin:link.download': return (new A($param('text', $this->name() ?: '(без имени)'), $this->urlAsset('url.view', $params), $param('title')));
        }

        throw new \Exception(sprintf('Unknown url asset %s in scope %s', $key, $scope));
    }
}
