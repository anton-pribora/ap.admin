<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Track extends AbstractElement
{
    protected $tagName = 'track';

    /**
     * Set The type of text track
     * 
     * @param $value
     */
    function setKind($value)
    {
        $this->setAttribute("kind", $value);
        return $this;
    }

    /**
     * Get The type of text track
     */
    function getKind()
    {
        return $this->getAttribute("kind");
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
     * Set Language of the text track
     * 
     * @param $value
     */
    function setSrclang($value)
    {
        $this->setAttribute("srclang", $value);
        return $this;
    }

    /**
     * Get Language of the text track
     */
    function getSrclang()
    {
        return $this->getAttribute("srclang");
    }

    /**
     * Set User-visible label
     * 
     * @param $value
     */
    function setLabel($value)
    {
        $this->setAttribute("label", $value);
        return $this;
    }

    /**
     * Get User-visible label
     */
    function getLabel()
    {
        return $this->getAttribute("label");
    }

    /**
     * Set Enable the track if no other text track is more suitable
     * 
     * @param $value
     */
    function setDefault($value)
    {
        $this->setAttribute("default", $value);
        return $this;
    }

    /**
     * Get Enable the track if no other text track is more suitable
     */
    function getDefault()
    {
        return $this->getAttribute("default");
    }
}
