<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Log;

class Format
{
    private $format = '';
    private $static = [];
    
    public function setFormat($format)
    {
        $this->format = $format;
    }
    
    public function setStaticVariables($variables)
    {
        foreach ($variables as $key => $value) {
            $this->static[ $key ] = $value;
        }
    }
    
    public function format($variables = [])
    {
        $vars = array_merge($this->static, $variables);
        
        return preg_replace_callback('~\\{(\\w+)\\}~', function($matches) use ($vars){
            $key   = $matches[1];
            $value = isset($vars[$key]) ? $vars[$key] : $matches[0];
            
            return is_callable($value) ? $value() : $value; 
        }, $this->format);
    }
}