<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

class ComplexResult
{
    private $output;
    private $result;
    
    public function setOutput($value)
    {
        $this->output = $value;
        return $this;
    }
    
    public function output()
    {
        return $this->output;
    }
    
    public function setResult($value)
    {
        $this->result = $value;
        return $this;
    }
    
    public function result()
    {
        return $this->result;
    }
    
    public function __toString()
    {
        return $this->output;
    }
}