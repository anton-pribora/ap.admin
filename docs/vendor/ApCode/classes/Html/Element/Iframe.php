<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Iframe extends ContentableElement
{
    protected $tagName = 'iframe';

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
     * Set A document to render in the iframe
     * 
     * @param $value
     */
    function setSrcdoc($value)
    {
        $this->setAttribute("srcdoc", $value);
        return $this;
    }

    /**
     * Get A document to render in the iframe
     */
    function getSrcdoc()
    {
        return $this->getAttribute("srcdoc");
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
     * Set Security rules for nested content
     * 
     * @param $value
     */
    function setSandbox($value)
    {
        $this->setAttribute("sandbox", $value);
        return $this;
    }

    /**
     * Get Security rules for nested content
     */
    function getSandbox()
    {
        return $this->getAttribute("sandbox");
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
