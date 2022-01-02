<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpGroupOfProperties
{
    protected $properties = [];
    
    public function hasProperties()
    {
        return count($this->properties) > 0;
    }
    
    public function getProperties()
    {
        return $this->properties;
    }
    
    public function createProperty($name)
    {
        $property = new PhpClassProperty($name);
        $this->properties[] = $property;
        
        return $property;
    }
    
    public function getMaxNameLen()
    {
        $max = 0;
        
        foreach ($this->properties  as $property)
        {
            $max = max($max, mb_strlen($property->getName()));
        }
        
        return $max;
    }
    
    public function getMaxDefinitionLen()
    {
        $max = 0;
        
        foreach ($this->properties  as $property)
        {
            $max = max($max, mb_strlen($property->getName()) + mb_strlen($property->getAccessType()));
        }
        
        return $max;
    }
}