<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpClassProperty extends PhpVariable
{
    protected $static = null;
    
    protected $accessType = 'public';
    
    public function setStatic($bool)
    {
        $this->static = (bool) $bool;
        return $this;
    }
    
    public function isStatic()
    {
        return (bool) $this->static;
    }
    
    public function getAccessType()
    {
        return $this->accessType;
    }
    
    public function setAccessTypeProtected()
    {
        $this->accessType = 'protected';
        return $this;
    }
}