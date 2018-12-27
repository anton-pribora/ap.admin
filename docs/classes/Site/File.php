<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

use Replica\ReplicaRecordInterface;
use Replica\ReplicaTable;
use Interfaces\Data\UrlAssetInterface;
use ApCode\Html\Element\A;
use Gotcha\GotchaRecordInterface;

class File extends Item implements ReplicaRecordInterface, UrlAssetInterface, GotchaRecordInterface
{
    protected $type = 'file';
    
    protected function afterSave()
    {
        Gotcha()->updateRecord($this);
        Replica()->update($this);
    }
    
    public function setParentItemId($value)
    {
        return parent::setParentItemId($value);
    }
    
    public function info()
    {
        return new File\FileInformation($this->meta()->getLink($this->type .'.info'));
    }
    
    public function name()
    {
        return $this->info()->name();
    }
    
    public function makeGuid()
    {
        $this->info()->setGuid(substr(sha1(uniqid()), 4, 10));
        return $this;
    }
    
    public function makePath()
    {
        if (empty($this->info()->guid())) {
            $this->makeGuid();
        }
        
        $guid = $this->info()->guid();
        $path = mb_substr($guid, 0, 2) .'/'. mb_substr($guid, 2);
        
        $this->info()->setPath("@uploads/$path");
        
        return $this;
    }
    
    public function fullPath()
    {
        return ExpandPath($this->info()->path());
    }
    
    /**
     * {@inheritDoc}
     * @see \Replica\ReplicaRecordInterface::replicaTables()
     */
    public function replicaTables()
    {
        return [
            new ReplicaTable('site_file', 'id', [
                'id'   => $this->id(),
                'guid' => $this->info()->guid(),
            ])
        ];
    }
    
    /**
     * {@inheritDoc}
     * @see \Gotcha\GotchaRecordInterface::gotchaType()
     */
    public function gotchaType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     * @see \Gotcha\GotchaRecordInterface::gotchaFields()
     */
    public function gotchaFields()
    {
        return [
            ['group', $this->info()->group()],
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
            case 'admin:url.download' : return ShortUrl('@root/consultant/profiles/profile/', ['profile_id' => $this->id()]);
            case 'admin:link.download': return (new A($param('text', $this->name() ?: '(без имени)'), $this->urlAsset('url.view', $params), $param('title')));
        }

        throw new \Exception(sprintf('Unkonw url asset %s in scope %s', $key, $scope));
    }
}