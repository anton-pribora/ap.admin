<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data\Report;

class Column
{
    private $key;
    private $title;
    private $params = [];
    
    public function __construct($key, $title = NULL, array $params = NULL)
    {
        $this->key    = $key;
        $this->title  = $title;
        $this->params = $params;
    }
    
    public function key()
    {
        return $this->key;
    }
    
    public function title()
    {
        return $this->title;
    }
    
    public function params()
    {
        return $this->params;
    }
    
    public function hasParam($key)
    {
        return isset($this->params[$key]);
    }
    
    public function param($key, $default = NULL)
    {
        return isset($this->params[$key]) ? $this->params[$key] : $default;
    }
    
    public function setParam($key, $value)
    {
        $this->params[$key]= $value;
    }
}