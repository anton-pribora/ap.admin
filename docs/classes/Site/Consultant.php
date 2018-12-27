<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

use Gotcha\GotchaRecordInterface;
use Replica\ReplicaRecordInterface;
use Replica\ReplicaTable;
use Interfaces\Data\UrlAssetInterface;
use ApCode\Html\Element\A;

class Consultant extends Item implements GotchaRecordInterface, ReplicaRecordInterface, UrlAssetInterface
{
    protected $type = 'consultant';
    
    protected static $roles = [
        'admin'     => 'Администратор',
        'manager'   => 'Менеджер',
    ];
    
    protected function afterSave()
    {
        Gotcha()->updateRecord($this);
        Replica()->update($this);
    }
    
    public function jdiId()
    {
        return 'u' . $this->id();
    }
    
    public function info()
    {
        return new Consultant\ConsultantInfo($this->meta()->getLink("{$this->type}.info"));
    }
    
    public function name()
    {
        return $this->info()->firstName() .' '. $this->info()->lastName();
    }
    
    public function hasPermit($action, ...$data)
    {
        return Module('permissions')->execute("{$this->type}/{$action}.php", $this, ...$data);
    }
    
    public static function roles()
    {
        return static::$roles;
    }
    
    public function roleId()
    {
        return $this->info()->roleId();
    }
    
    public function setRoleId($value)
    {
        $this->info()->setRoleId($value);
        return $this;
    }
    
    public function roleName()
    {
        return $this->info()->roleName();
    }
    
    public function hasRole($roleId)
    {
        return $this->roleId() == $roleId;
    }
    
    /**
     * {@inheritDoc}
     * @see \Replica\ReplicaRecordInterface::replicaTables()
     */
    public function replicaTables()
    {
        return [
            new ReplicaTable('site_login', 'id', [
                'id'    => $this->id(),
                'login' => $this->info()->login(),
                'type'  => $this->type(),
            ])
        ];
    }
    
    /**
     * {@inheritDoc}
     * @see \Gotcha\GotchaRecordInterface::gotchaType()
     */
    public function gotchaType()
    {
        return $this->type();
    }

    /**
     * {@inheritDoc}
     * @see \Gotcha\GotchaRecordInterface::gotchaFields()
     */
    public function gotchaFields()
    {
        return [
            ['login', $this->info()->login()],
            ['name', $this->name()],
            ['roleId', $this->info()->roleId()],
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Interfaces\Data\UrlAssetInterface::urlAsset()
     */
    public function urlAsset($key, $params = NULL)
    {
        $param = function($name, $default = null) use(&$params) { return isset($params[$name]) ? $params[$name] : $default; };
        $scope = $param('scope', Config()->get('urlAsset.scope', 'admin'));

        switch ("$scope:$key") {
            case 'admin:url.view' : return ShortUrl('@root/consultant/profiles/all/profile/', ['profile_id' => $this->id()]);
            case 'admin:link.view': return (new A($param('text', trim($this->name()) ?: '(nameless)'), $this->urlAsset('url.view', $params), $param('title')));
        }

        throw new \Exception(sprintf('Unkonw url asset %s in scope %s', $key, $scope));
    }
}