<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Param extends AbstractElement
{
    protected $tagName = 'param';

    /**
     * Set Name of parameter
     * 
     * @param $value
     */
    function setName($value)
    {
        $this->setAttribute("name", $value);
        return $this;
    }

    /**
     * Get Name of parameter
     */
    function getName()
    {
        return $this->getAttribute("name");
    }

    /**
     * Set Value of parameter
     * 
     * @param $value
     */
    function setValue($value)
    {
        $this->setAttribute("value", $value);
        return $this;
    }

    /**
     * Get Value of parameter
     */
    function getValue()
    {
        return $this->getAttribute("value");
    }
}
