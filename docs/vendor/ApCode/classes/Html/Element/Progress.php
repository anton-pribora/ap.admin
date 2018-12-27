<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Progress extends ContentableElement
{
    protected $tagName = 'progress';

    /**
     * Set Current value of the element
     * 
     * @param $value
     */
    function setValue($value)
    {
        $this->setAttribute("value", $value);
        return $this;
    }

    /**
     * Get Current value of the element
     */
    function getValue()
    {
        return $this->getAttribute("value");
    }

    /**
     * Set Upper bound of range
     * 
     * @param $value
     */
    function setMax($value)
    {
        $this->setAttribute("max", $value);
        return $this;
    }

    /**
     * Get Upper bound of range
     */
    function getMax()
    {
        return $this->getAttribute("max");
    }
}
