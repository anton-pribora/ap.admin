<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Config;

class Config
{
    private $storage = [];
    
    public function setup(array $config)
    {
        $this->storage = array_replace_recursive($this->storage, $config);
    }
    
    public function get($path, $default = null)
    {
        $params = explode('.', $path);
        
        return eval('return isset($this->storage["'. join('"]["', $params) .'"]) ? $this->storage["'. join('"]["', $params) .'"] : $default;');
    }
    
    public function set($path, $value)
    {
        $params = explode('.', $path);
        eval('$this->storage["'. join('"]["', $params) .'"] = $value;');
    }
    
    public function clear()
    {
        $this->storage = [];
    }
}