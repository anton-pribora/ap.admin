<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class ObjectElement extends ContentableElement
{
    protected $tagName = 'object';

    /**
     * Set Address of the resource
     * 
     * @param $value
     */
    function setData($value)
    {
        $this->setAttribute("data", $value);
        return $this;
    }

    /**
     * Get Address of the resource
     */
    function getData()
    {
        return $this->getAttribute("data");
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
     * Set Whether the type attribute and the Content-Type value need to match for the resource to be used
     * 
     * @param $value
     */
    function setTypeMustMatch($value)
    {
        $this->setAttribute("typemustmatch", $value);
        return $this;
    }

    /**
     * Get Whether the type attribute and the Content-Type value need to match for the resource to be used
     */
    function getTypeMustMatch()
    {
        return $this->getAttribute("typemustmatch");
    }

    /**
     * Set Name of nested browsing context
     * 
     * @param $value
     */
    function setName($value)
    {
        $this->setAttribute("name", $value);
        return $this;
    }

    /**
     * Get Name of nested browsing context
     */
    function getName()
    {
        return $this->getAttribute("name");
    }

    /**
     * Set Name of image map to use
     * 
     * @param $value
     */
    function setUseMap($value)
    {
        $this->setAttribute("usemap", $value);
        return $this;
    }

    /**
     * Get Name of image map to use
     */
    function getUseMap()
    {
        return $this->getAttribute("usemap");
    }

    /**
     * Set Associates the control with a form element
     * 
     * @param $value
     */
    function setForm($value)
    {
        $this->setAttribute("form", $value);
        return $this;
    }

    /**
     * Get Associates the control with a form element
     */
    function getForm()
    {
        return $this->getAttribute("form");
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
