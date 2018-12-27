<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Area extends AbstractElement
{
    protected $tagName = 'area';

    /**
     * Set Replacement text for use when images are not available
     * 
     * @param $value
     */
    function setAlt($value)
    {
        $this->setAttribute("alt", $value);
        return $this;
    }

    /**
     * Get Replacement text for use when images are not available
     */
    function getAlt()
    {
        return $this->getAttribute("alt");
    }

    /**
     * Set Coordinates for the shape to be created in an image map
     * 
     * @param $value
     */
    function setCoords($value)
    {
        $this->setAttribute("coords", $value);
        return $this;
    }

    /**
     * Get Coordinates for the shape to be created in an image map
     */
    function getCoords()
    {
        return $this->getAttribute("coords");
    }

    /**
     * Set Whether to download the resource instead of navigating to it, and its file name if so
     * 
     * @param $value
     */
    function setDownload($value)
    {
        $this->setAttribute("download", $value);
        return $this;
    }

    /**
     * Get Whether to download the resource instead of navigating to it, and its file name if so
     */
    function getDownload()
    {
        return $this->getAttribute("download");
    }

    /**
     * Set Address of the hyperlink
     * 
     * @param $value
     */
    function setHref($value)
    {
        $this->setAttribute("href", $value);
        return $this;
    }

    /**
     * Get Address of the hyperlink
     */
    function getHref()
    {
        return $this->getAttribute("href");
    }

    /**
     * Set Language of the linked resource
     * 
     * @param $value
     */
    function setHreflang($value)
    {
        $this->setAttribute("hreflang", $value);
        return $this;
    }

    /**
     * Get Language of the linked resource
     */
    function getHreflang()
    {
        return $this->getAttribute("hreflang");
    }

    /**
     * Set The kind of shape to be created in an image map
     * 
     * @param $value
     */
    function setShape($value)
    {
        $this->setAttribute("shape", $value);
        return $this;
    }

    /**
     * Get The kind of shape to be created in an image map
     */
    function getShape()
    {
        return $this->getAttribute("shape");
    }

    /**
     * Set Browsing context for hyperlink navigation
     * 
     * @param $value
     */
    function setTarget($value)
    {
        $this->setAttribute("target", $value);
        return $this;
    }

    /**
     * Get Browsing context for hyperlink navigation
     */
    function getTarget()
    {
        return $this->getAttribute("target");
    }

    /**
     * Set Hint for the type of the referenced resource
     * 
     * @param $value
     */
    function setType($value)
    {
        $this->setAttribute("type", $value);
        return $this;
    }

    /**
     * Get Hint for the type of the referenced resource
     */
    function getType()
    {
        return $this->getAttribute("type");
    }
}
