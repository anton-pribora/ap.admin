<?php

namespace Project;

/**
 * Role
 */
class Role extends \ApCode\Billet\AbstractBillet implements \Interfaces\Data\UrlAssetInterface
{
    use History;
    use Meta;

    public function id()
    {
        return $this->data['id'] ?? null;
    }

    public function setId($value)
    {
        $this->data['id'] = $value;
        return $this;
    }

    public function tag()
    {
        return $this->data['tag'] ?? null;
    }

    public function setTag($value)
    {
        $this->data['tag'] = $value;
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

    public function comment()
    {
        return $this->data['comment'] ?? null;
    }

    public function setComment($value)
    {
        $this->data['comment'] = $value;
        return $this;
    }

    public function permissions()
    {
        return $this->data['permissions'] ?? null;
    }

    public function setPermissions($value)
    {
        $this->data['permissions'] = $value;
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

    public function del()
    {
        return $this->data['del'] ?? null;
    }

    public function setDel($value)
    {
        $this->data['del'] = $value;
        return $this;
    }

    public function urlAsset($key, $params = null)
    {
        $param = function($name, $default = null) use(&$params) { return isset($params[$name]) ? $params[$name] : $default; };
        $scope = $param('scope', Config()->get('urlAsset.scope', 'admin'));

        switch ("$scope:$key") {
            case 'admin:url.view' : return ShortUrl('@consultant/administration/roles/one/', ['role_id' => $this->id()]);

            case 'admin:link.view': return (new \ApCode\Html\Element\A($param('text', $this->name() ?: '(без названия)'), $this->urlAsset('url.view', $params), $param('title')));
        }

        trigger_error(sprintf('Unknown url asset %s in scope %s', $key, $scope), E_USER_WARNING);
        return null;
    }
}
