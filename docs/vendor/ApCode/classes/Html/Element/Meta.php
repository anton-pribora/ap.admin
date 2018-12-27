<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Meta extends AbstractElement
{
    protected $tagName = 'meta';

    /**
     * Set Metadata name
     * 
     * @param $value
     */
    function setName($value)
    {
        $this->setAttribute("name", $value);
        return $this;
    }

    /**
     * Get Metadata name
     */
    function getName()
    {
        return $this->getAttribute("name");
    }

    /**
     * Set Pragma directive
     * 
     * @param $value
     */
    function setHttpEquiv($value)
    {
        $this->setAttribute("http-equiv", $value);
        return $this;
    }

    /**
     * Get Pragma directive
     */
    function getHttpEquiv()
    {
        return $this->getAttribute("http-equiv");
    }

    /**
     * Set Value of the element
     * 
     * @param $value
     */
    function setContent($value)
    {
        $this->setAttribute("content", $value);
        return $this;
    }

    /**
     * Get Value of the element
     */
    function getContent()
    {
        return $this->getAttribute("content");
    }

    /**
     * Set Character encoding declaration
     * 
     * @param $value
     */
    function setCharset($value)
    {
        $this->setAttribute("charset", $value);
        return $this;
    }

    /**
     * Get Character encoding declaration
     */
    function getCharset()
    {
        return $this->getAttribute("charset");
    }
}
