<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpValue
{
    protected $value = null;
    
    public function __construct($value = null)
    {
        $this->value = $value;
    }
    
    public function isMultiLine()
    {
        return false;
    }
    
    public function getDefinitionAsLineArray($indent = null)
    {
        return [ $this->value ];
    }
    
    public function render()
    {
        return var_export($this->value, true);
    }
    
    public function __toString()
    {
        return $this->render();
    }
}