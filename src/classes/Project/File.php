<?php

namespace Project;

/**
 * (Без названия)
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

    public function type()
    {
        return $this->data['type'] ?? null;
    }

    public function setType($value)
    {
        $this->data['type'] = $value;
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

    public function createdAt()
    {
        return $this->data['createdAt'] ?? null;
    }

    public function setCreatedAt($value)
    {
        $this->data['createdAt'] = $value;
        return $this;
    }

    public function urlAsset($key, $params = null)
    {
        $param = function($name, $default = null) use(&$params) { return isset($params[$name]) ? $params[$name] : $default; };
        $scope = $param('scope', Config()->get('urlAsset.scope', 'admin'));
    
        switch ("$scope:$key") {
            case 'admin:url.view' : return ShortUrl('@consultant/unknown/one/', ['record_id' => $this->id()]);

            case 'admin:link.view': return (new \ApCode\Html\Element\A($param('text', $this->name() ?: '(без названия)'), $this->urlAsset('url.view', $params), $param('title')));
        }
    
        throw new \Exception(sprintf('Unknown url asset %s in scope %s', $key, $scope));
    }
}