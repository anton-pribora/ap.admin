<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Time extends ContentableElement
{
    protected $tagName = 'time';

    /**
     * Set Machine-readable value
     * 
     * @param $value
     */
    function setDateTime($value)
    {
        $this->setAttribute("datetime", $value);
        return $this;
    }

    /**
     * Get Machine-readable value
     */
    function getDateTime()
    {
        return $this->getAttribute("datetime");
    }
}
