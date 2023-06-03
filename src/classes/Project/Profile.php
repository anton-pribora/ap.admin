<?php

namespace Project;

/**
 * Сотрудники
 */
class Profile extends \ApCode\Billet\AbstractBillet implements \Interfaces\Data\UrlAssetInterface
{
    use Meta,
        Contacts,
        ProfileProps,
        Files,
        Roles,
        RoleAdmin,
        Permissions,
        History;

    protected function beforeSave()
    {
        $this->data['name'] = $this->fullName();
    }

    public function urlAsset($key, $params = null)
    {
        $param = function($name, $default = null) use(&$params) { return isset($params[$name]) ? $params[$name] : $default; };
        $scope = $param('scope', Config()->get('urlAsset.scope', 'admin'));

        switch ("$scope:$key") {
            case 'admin:url.view' : return ShortUrl('@consultant/administration/profiles/one/', ['profile_id' => $this->id()]);

            case 'admin:link.view': return (new \ApCode\Html\Element\A($param('text', $this->name() ?: '(без имени)'), $this->urlAsset('url.view', $params), $param('title')));
        }

        trigger_error(sprintf('Unknown url asset %s in scope %s', $key, $scope), E_USER_WARNING);
        return null;
    }

    public function toArray()
    {
        return [
            'id'           => $this->id(),
            'name'         => [
                'first'    => $this->firstName(),
                'last'     => $this->lastName(),
                'middle'   => $this->middleName(),
            ],
            'post'         => $this->post(),
            'del'          => $this->del()
        ];
    }

    public function name()
    {
        return $this->fullName();
    }
}
