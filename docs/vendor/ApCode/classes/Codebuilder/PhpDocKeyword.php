<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpDocKeyword
{
    protected $name = null;
    
    protected $value = null;
    
    public function __construct($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getValue()
    {
        return $this->value;
    }
}