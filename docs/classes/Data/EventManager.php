<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

class EventManager
{
    private $args   = [];
    private $params = [];
    
    public function rise($event, ...$args)
    {
        $this->args = $args;
        
        if (is_array(end($args))) {
            $this->params = end($args);
        }
        
        $file = ExpandPath('@root/events/') . strtr($event, '.', '/') .'.php';
        
        return include $file;
    }
    
    private function argument($index = 0, $default = NULL)
    {
        return isset($this->args[$index]) ? $this->args[$index] : $default;
    }
    
    private function param($name, $default = NULL)
    {
        return isset($this->params[$name]) ? $this->params[$name] : $default;
    }
}