<?php

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

        trigger_error(sprintf('Unkown icon "%s" size "%s". Please setup the icon in the config file.', $icon, $size), E_USER_WARNING);
    }
}
