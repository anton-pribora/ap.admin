<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Canvas extends ContentableElement
{
    protected $tagName = 'canvas';

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

    /**
     * Set Vertical dimension
     * 
     * @param $value
     */
    function setHeight($value)
    {
        $this->setAttribute("height", $value);
        return $this;
    }

    /**
     * Get Vertical dimension
     */
    function getHeight()
    {
        return $this->getAttribute("height");
    }
}
