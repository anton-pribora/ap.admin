<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Billet\Storage;

use ApCode\Billet\StorageInterface;

class Memory implements StorageInterface
{
    private $records = [];
    private $limit;
    
    public function __construct($limit = 100)
    {
        $this->limit = $limit;
    }
    
    public function clearCache()
    {
        $this->records = [];
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Billet\StorageInterface::getRecord()
     */
    public function getRecord($class, $id)
    {
        $key = "$class:$id";
        
        if (isset($this->records[$key])) {
            return $this->records[$key];
        }
        
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Billet\StorageInterface::saveRecord()
     */
    public function saveRecord(\ApCode\Billet\BaseBillet $billet)
    {
        $id = $billet->billetId();
        
        if ($id) {
            $key = get_class($billet) .":$id";
            
            if (count($this->records) >= $this->limit) {
                $this->records = [];
            }
            
            $this->records[$key] = $billet;
        }
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Billet\StorageInterface::removeRecord()
     */
    public function removeRecord(\ApCode\Billet\BaseBillet $billet)
    {
        $id = $billet->billetId();
        
        if ($id) {
            $key = get_class($billet) .":$id";
            unset($this->records[$key]);
        }
    }
}