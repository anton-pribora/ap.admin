<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpFunction extends PhpElement
{
    protected $arguments = [];
    
    protected $body = [];
    
    protected $returnTypes = [];
    
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
    
    public function hasBody()
    {
        return count($this->body) > 0;
    }
    
    public function addBodyLine($line)
    {
        $this->body[] = $line;
        return $this;
    }
    
    public function getBodyLines()
    {
        return $this->body;
    }
    
    public function hasArguments()
    {
        return count($this->arguments) > 0;
    }
    
    public function getArguments()
    {
        return $this->arguments;
    }
    
    public function createArgument($name)
    {
        $argument = new PhpFunctionArgument($name);
        $this->arguments[] = $argument;
        
        return $argument;
    }
    
    public function hasReturnTypes()
    {
        return count($this->returnTypes) > 0;
    }
    
    public function getReturnTypes()
    {
        return $this->returnTypes;
    }
    
    public function addReturnType(PhpType $type)
    {
        $this->returnTypes[] = $type;
        return $this;
    }
    
    public function addReturnTypeString()
    {
        $this->addReturnType(new PhpTypeString());
        return $this;
    }
    
    public function addReturnTypeArray()
    {
        $this->addReturnType(new PhpTypeArray());
        return $this;
    }
    
    public function addReturnTypeNull()
    {
        $this->addReturnType(new PhpTypeNull());
        return $this;
    }
    
    public function addReturnTypeClass(PhpClass $class)
    {
        $this->addReturnType(new PhpTypeClass($class));
        return $this;
    }
}