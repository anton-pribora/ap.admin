<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Data extends ContentableElement
{
    protected $tagName = 'data';

    /**
     * Set Machine-readable value
     * 
     * @param $value
     */
    function setValue($value)
    {
        $this->setAttribute("value", $value);
        return $this;
    }

    /**
     * Get Machine-readable value
     */
    function getValue()
    {
        return $this->getAttribute("value");
    }
}
