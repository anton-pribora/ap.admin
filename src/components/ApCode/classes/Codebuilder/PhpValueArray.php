<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpValueArray extends PhpValue
{
    public function isMultiLine()
    {
        return count($this->value) > 0;
    }
    
    public function getDefinitionAsLineArray($indent = null)
    {
        $result   = [];
        $result[] = '[';
        
        $maxKeyLen = 0;
        
        if ( $this->isMultiLine() )
        {
            foreach ( $this->value as $key => $value )
            {
                $maxKeyLen = max($maxKeyLen, mb_strlen(var_export($key, true)));
            }
        }
        else 
        {
            $indent = '';
        }
        
        foreach ( $this->value as $key => $value )
        {
            if ( is_array($value) )
            {
                $subArray = new self($value);
                
                if ( $subArray->isMultiLine() )
                {
                    $lines     = $subArray->getDefinitionAsLineArray($indent);
                    $firstLine = array_shift($lines);
                    $result[]  = $indent . sprintf('%-'. $maxKeyLen .'s => %s', var_export($key, true), $firstLine);
                    
                    foreach ($lines as $line)
                    {
                        $result[] = $indent . $line;
                    }
                    
                    $result[ count($result) - 1 ] .= ',';
                }
                else 
                {
                    $result[]  = $indent . sprintf('%-'. $maxKeyLen .'s => %s,', var_export($key, true), $subArray->render($indent));
                }
            }
            else 
            {
                if ( $value instanceof PhpValue )
                {
                    $result[] = $indent . sprintf('%-'. $maxKeyLen .'s => %s,', var_export($key, true), $value->render($indent));
                }
                else 
                {
                    $result[] = $indent . sprintf('%-'. $maxKeyLen .'s => %s,', var_export($key, true), var_export($value, true));
                }
            }
        }
        
        $result[] = ']';
        
        return $result;
    }
    
    public function render($indent = null)
    {
        return join($this->isMultiLine() ? PHP_EOL : ' ', $this->getDefinitionAsLineArray($indent));
    }
    
    public function __toString()
    {
        $result = [];
        $keys   = [];
        
        foreach ( $this->value as $key => $value )
        {
            $keys[] = var_export($key, true);
        }
        
        return var_export($this->value, true);
    }
}