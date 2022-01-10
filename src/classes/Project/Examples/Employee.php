<?php

namespace Project\Examples;

use Project\File;

/**
 * Сотрудники компании
 */
class Employee extends \ApCode\Billet\AbstractBillet implements \Interfaces\Data\UrlAssetInterface
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

    public function name()
    {
        return $this->data['name'] ?? null;
    }

    public function setName($value)
    {
        $this->data['name'] = $value;
        return $this;
    }

    public function post()
    {
        return $this->data['post'] ?? null;
    }

    public function setPost($value)
    {
        $this->data['post'] = $value;
        return $this;
    }

    public function responsibilities()
    {
        return $this->data['responsibilities'] ?? null;
    }

    public function setResponsibilities($value)
    {
        $this->data['responsibilities'] = $value;
        return $this;
    }

    public function meta()
    {
        return $this->data['meta'] ?? null;
    }

    public function setMeta($value)
    {
        $this->data['meta'] = $value;
        return $this;
    }

    public function setAvatar(File $file)
    {
        $this->data['meta']['avatar'] = $file->id();
        return $this;
    }

    public function avatar()
    {
        return File::getInstance($this->data['meta']['avatar'] ?? null);
    }

    public function urlAsset($key, $params = null)
    {
        $param = function($name, $default = null) use(&$params) { return isset($params[$name]) ? $params[$name] : $default; };
        $scope = $param('scope', Config()->get('urlAsset.scope', 'admin'));

        switch ("$scope:$key") {
            case 'admin:url.view' : return ShortUrl('@consultant/examples/employee/one/', ['employee_id' => $this->id()]);

            case 'admin:link.view': return (new \ApCode\Html\Element\A($param('text', $this->name() ?: '(без названия)'), $this->urlAsset('url.view', $params), $param('title')));
        }

        throw new \Exception(sprintf('Unknown url asset %s in scope %s', $key, $scope));
    }
}
