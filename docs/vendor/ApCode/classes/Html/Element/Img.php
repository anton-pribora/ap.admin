<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Img extends AbstractElement
{
    protected $tagName = 'img';

    public function __construct($src = null)
    {
        parent::__construct();
        
        if ( isset($src) )
        {
            $this->setSrc($src);
        }
    }
    
    
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
     * Set Whether the image is a server-side image map
     * 
     * @param $value
     */
    function setIsMap($value)
    {
        $this->setAttribute("ismap", $value);
        return $this;
    }

    /**
     * Get Whether the image is a server-side image map
     */
    function getIsMap()
    {
        return $this->getAttribute("ismap");
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
