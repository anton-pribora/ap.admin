<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Embed extends AbstractElement
{
    protected $tagName = 'embed';

    /**
     * Set Address of the resource
     * 
     * @param $value
     */
    function setSrc($value)
    {
        $this->setAttribute("src", $value);
        return $this;
    }

    /**
     * Get Address of the resource
     */
    function getSrc()
    {
        return $this->getAttribute("src");
    }

    /**
     * Set Type of embedded resource
     * 
     * @param $value
     */
    function setType($value)
    {
        $this->setAttribute("type", $value);
        return $this;
    }

    /**
     * Get Type of embedded resource
     */
    function getType()
    {
        return $this->getAttribute("type");
    }

    /**
     * Set Horizontal dimension
     * 
     * @param $value
     */
    function setWidth($value)
    {
        $this->setAttribute("width", $value);
        return $this;
    }

    /**
     * Get Horizontal dimension
     */
    function getWidth()
    {
        return $this->getAttribute("width");
    }
}
