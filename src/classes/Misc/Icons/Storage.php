<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Misc\Icons;

class Storage
{
    private $icons = [];
    
    function set($icon, $value, $size = 'small')
    {
        if (!isset($this->icons[$icon])) {
            $this->icons[$icon] = [];
        }
        
        if (is_array($value)) {
            $this->icons[$icon] = array_merge($this->icons[$icon], $value);
        } else {
            $this->icons[$icon][$size] = $value;
        }
    }
    
    function get($icon, $size = 'small')
    {
        if (isset($this->icons[$icon][$size])) {
            return $this->icons[$icon][$size];
        }
        
        throw new \Exception(sprintf('Unkown icon "%s" size "%s". Please setup the icon in the config file.', $icon, $size));
    }
}