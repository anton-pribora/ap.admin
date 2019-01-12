<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Script extends ContentableElement
{
    protected $tagName = 'script';
    
    protected $addHtmlInsteadOfText = true;

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
     * Set Character encoding of the external script resource
     * 
     * @param $value
     */
    function setCharset($value)
    {
        $this->setAttribute("charset", $value);
        return $this;
    }

    /**
     * Get Character encoding of the external script resource
     */
    function getCharset()
    {
        return $this->getAttribute("charset");
    }

    /**
     * Set Execute script asynchronously
     * 
     * @param $value
     */
    function setAsync($value)
    {
        $this->setAttribute("async", $value);
        return $this;
    }

    /**
     * Get Execute script asynchronously
     */
    function getAsync()
    {
        return $this->getAttribute("async");
    }

    /**
     * Set Defer script execution
     * 
     * @param $value
     */
    function setDefer($value)
    {
        $this->setAttribute("defer", $value);
        return $this;
    }

    /**
     * Get Defer script execution
     */
    function getDefer()
    {
        return $this->getAttribute("defer");
    }

    /**
     * Set How the element handles crossorigin requests
     * 
     * @param $value
     */
    function setCrossOrigin($value)
    {
        $this->setAttribute("crossorigin", $value);
        return $this;
    }

    /**
     * Get How the element handles crossorigin requests
     */
    function getCrossOrigin()
    {
        return $this->getAttribute("crossorigin");
    }
}
