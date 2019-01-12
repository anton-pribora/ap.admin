<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Link extends AbstractElement
{
    protected $tagName = 'link';

    public function __construct($rel = null, $type = null, $href = null, $title = null)
    {
        parent::__construct();
        
        $this->setRel($rel);
        $this->setType($type);
        $this->setHref($href);
        $this->setTitle($title);
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
     * Set Relationship between the document containing the hyperlink and the destination resource
     * 
     * @param $value
     */
    function setRel($value)
    {
        $this->setAttribute("rel", $value);
        return $this;
    }

    /**
     * Get Relationship between the document containing the hyperlink and the destination resource
     */
    function getRel()
    {
        return $this->getAttribute("rel");
    }

    /**
     * Set Applicable media
     * 
     * @param $value
     */
    function setMedia($value)
    {
        $this->setAttribute("media", $value);
        return $this;
    }

    /**
     * Get Applicable media
     */
    function getMedia()
    {
        return $this->getAttribute("media");
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

    /**
     * Set Sizes of the icons (for rel="icon")
     * 
     * @param $value
     */
    function setSizes($value)
    {
        $this->setAttribute("sizes", $value);
        return $this;
    }

    /**
     * Get Sizes of the icons (for rel="icon")
     */
    function getSizes()
    {
        return $this->getAttribute("sizes");
    }
}
