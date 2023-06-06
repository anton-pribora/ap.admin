<?php

namespace Project;

use Data\Thumbnail;

/**
 * (Без названия)
 */
class File extends \ApCode\Billet\AbstractBillet implements \Interfaces\Data\UrlAssetInterface
{
    use Meta;

    public function makeGuid()
    {
        $this->setGuid(substr(sha1(random_bytes(16)), 0, 10));
        return $this;
    }

    public function id()
    {
        return $this->data['id'] ?? null;
    }

    public function setId($value)
    {
        $this->data['id'] = $value;
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

    public function public()
    {
        return boolval($this->data['public'] ?? null);
    }

    public function setPublic($value)
    {
        $this->data['public'] = boolval($value);
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

    public function mime()
    {
        return $this->data['mime'] ?? null;
    }

    public function setMime($value)
    {
        $this->data['mime'] = $value;
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

    public function path()
    {
        return $this->data['path'] ?? null;
    }

    public function setPath($value)
    {
        $this->data['path'] = $value;
        return $this;
    }

    public function makePath($subFolder = null)
    {
        if (empty($this->guid())) {
            $this->makeGuid();
        }

        $path = join('/', array_filter([
            trim((string) $subFolder, '/'),
            substr($this->guid(), 0, 2),
            substr($this->guid(), 2, 2),
            substr($this->guid(), 4),
        ]));

        $this->setPath($path);

        return $this;
    }

    public function fullPath()
    {
        return PathAlias()->expand('@files/' . $this->path());
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

    public function comment()
    {
        return $this->meta('comment');
    }

    public function setComment($value)
    {
        $this->setMeta('comment', $value);
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

    public function thumbnail($size)
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

    public function urlAsset($key, $params = null)
    {
        $param = function($name, $default = null) use(&$params) { return isset($params[$name]) ? $params[$name] : $default; };
        $scope = $param('scope', Config()->get('urlAsset.scope', 'admin'));

        switch ("$scope:$key") {
            case 'admin:url.view' : return ShortUrl('@root/public/file/index.php', ['guid' => $this->guid(), 'fileName' => $this->name()], true);

            case 'admin:link.view': return (new \ApCode\Html\Element\A($param('text', $this->name() ?: '(без названия)'), $this->urlAsset('url.view', $params), $param('title')));
        }

        throw new \Exception(sprintf('Unknown url asset %s in scope %s', $key, $scope));
    }
}
