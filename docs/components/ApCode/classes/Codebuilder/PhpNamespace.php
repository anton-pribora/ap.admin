<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpNamespace
{
    protected $name = null;
    
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    public function createClass($name)
    {
        return new PhpClass($name, $this);
    }
    
    public function createInterface($name)
    {
        return new PhpInterface($name, $this);
    }
    
    public function createSubNamespace($name)
    {
        return new PhpNamespace($this->getName() .'\\'. $name);
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function render()
    {
        return $this->getName();
    }
    
    public function __toString()
    {
        return (string) $this->render();
    }
}