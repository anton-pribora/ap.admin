<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpVariable extends PhpElement
{
    protected $defaultValue = null;
    
    protected $requiredType = null;
    
    protected $optionalTypes = [];
    
    public function hasRequiredType()
    {
        return isset($this->requiredType);
    }
    
    public function setRequiredType(PhpType $type)
    {
        $this->requiredType = $type;
        return $this;
    }
    
    public function getRequiredType()
    {
        return $this->requiredType;
    }
    
    public function setRequiredTypeClass(PhpInterface $class)
    {
        $this->setRequiredType(new PhpTypeClass($class));
        return $this;
    }
    
    public function setRequiredTypeString()
    {
        $this->requiredType = new PhpTypeString();
        return $this;
    }
    
    public function hasOptionalTypes()
    {
        return count($this->optionalTypes) > 0;
    }
    
    public function addOptionalType(PhpType $type)
    {
        $this->optionalTypes[] = $type;
        return $this;
    }
    
    public function addOptionalTypeString()
    {
        $this->addOptionalType(new PhpTypeString());
        return $this;
    }
    
    public function addOptionalTypeNull()
    {
        $this->addOptionalType(new PhpTypeNull());
        return $this;
    }
    
    public function addOptionalTypeClass(PhpInterface $class)
    {
        $this->addOptionalType(new PhpTypeClass($class));
        return $this;
    }
    
    
    public function getOptionalTypes()
    {
        return $this->optionalTypes;
    }
    
    public function hasDefaultValue()
    {
        return isset($this->defaultValue);
    }
    
    public function getDefaultValue()
    {
        return $this->hasDefaultValue() ? $this->defaultValue : new PhpValueNull();
    }
    
    public function setDefaultValue(PhpValue $value)
    {
        $this->defaultValue = $value;
        return $this;
    }
    
    public function setDefaultValueNull()
    {
        $value = new PhpValueNull();
        return $this->setDefaultValue($value);
    }
    
    public function setDefaultValueSingleQuoteString($value)
    {
        $value = new PhpValueSingleQuoteString($value);
        return $this->setDefaultValue($value);
    }
    
    public function setDefaultValuePhpCode($value)
    {
        $value = new PhpValueRawCode($value);
        return $this->setDefaultValue($value);
    }
    
    public function setDefaultValueConstant($value)
    {
        $value = new PhpValueRawCode($value);
        return $this->setDefaultValue($value);
    }
    
    public function setDefaultValueArray($value)
    {
        $value = new PhpValueArray($value);
        return $this->setDefaultValue($value);
    }
}