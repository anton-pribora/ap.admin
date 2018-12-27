<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpElement
{
    protected $name = null;
    
    protected $description = [];
    
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function hasDescription()
    {
        return count($this->description) > 0;
    }
    
    public function addDescription($description)
    {
        $this->description[] = $description;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function render()
    {
        return print_r($this, true);
    }
    
    public function __toString()
    {
        return $this->render();
    }
}