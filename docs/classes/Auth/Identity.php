<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Auth;

use Site\Consultant;

class Identity
{
    public $consultantId;
    
    private $activeEntryId;
    private $activeEntryName;
    private $activeEntryType;
    
    private $entries = [];
    
    public function consultant()
    {
        return Consultant::getInstance($this->consultantId);
    }
    
    public function setEntry($type, $id, $name)
    {
        $this->entries[$type] = [$id, $name];
    }
    
    public function require($type)
    {
        if (isset($this->entries[$type])) {
            $this->activeEntryType = $type;
            [$this->activeEntryId, $this->activeEntryName] = $this->entries[$type];
            $this->{$type .'Id'} = $this->activeEntryId;
            
            return true;
        }
        
        return false;
    }
    
    public function getName()
    {
        return $this->activeEntryName;
    }
    
    public function getId()
    {
        return $this->activeEntryId ? "{$this->activeEntryType}:{$this->activeEntryId}" : '';
    }

    public function logout()
    {
        if ($this->activeEntryType) {
            unset($this->entries[$this->activeEntryType]);
        }
    }
    
    public function valid()
    {
        return $this->activeEntryId > 0;
    }
    
    public function isEmpty()
    {
        return !$this->entries;
    }
    
    public function __sleep()
    {
        return ['entries'];
    }
}