<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

abstract class PhpType
{
    protected $value = null;
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function render()
    {
        return $this->getValue();
    }
    
    public function __toString()
    {
        return $this->render();
    }
}