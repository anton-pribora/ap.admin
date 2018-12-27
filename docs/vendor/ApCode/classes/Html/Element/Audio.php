<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Audio extends ContentableElement
{
    protected $tagName = 'audio';

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
    function setCrossorigin($value)
    {
        $this->setAttribute("crossorigin", $value);
        return $this;
    }

    /**
     * Get How the element handles crossorigin requests
     */
    function getCrossorigin()
    {
        return $this->getAttribute("crossorigin");
    }

    /**
     * Set Hints how much buffering the media resource will likely need
     * 
     * @param $value
     */
    function setPreload($value)
    {
        $this->setAttribute("preload", $value);
        return $this;
    }

    /**
     * Get Hints how much buffering the media resource will likely need
     */
    function getPreload()
    {
        return $this->getAttribute("preload");
    }

    /**
     * Set Hint that the media resource can be started automatically when the page is loaded
     * 
     * @param $value
     */
    function setAutoplay($value)
    {
        $this->setAttribute("autoplay", $value);
        return $this;
    }

    /**
     * Get Hint that the media resource can be started automatically when the page is loaded
     */
    function getAutoplay()
    {
        return $this->getAttribute("autoplay");
    }

    /**
     * Set Groups media elements together with an implicit MediaController
     * 
     * @param $value
     */
    function setMediagroup($value)
    {
        $this->setAttribute("mediagroup", $value);
        return $this;
    }

    /**
     * Get Groups media elements together with an implicit MediaController
     */
    function getMediagroup()
    {
        return $this->getAttribute("mediagroup");
    }

    /**
     * Set Whether to loop the media resource
     * 
     * @param $value
     */
    function setLoop($value)
    {
        $this->setAttribute("loop", $value);
        return $this;
    }

    /**
     * Get Whether to loop the media resource
     */
    function getLoop()
    {
        return $this->getAttribute("loop");
    }

    /**
     * Set Whether to mute the media resource by default
     * 
     * @param $value
     */
    function setMuted($value)
    {
        $this->setAttribute("muted", $value);
        return $this;
    }

    /**
     * Get Whether to mute the media resource by default
     */
    function getMuted()
    {
        return $this->getAttribute("muted");
    }

    /**
     * Set Show user agent controls
     * 
     * @param $value
     */
    function setControls($value)
    {
        $this->setAttribute("controls", $value);
        return $this;
    }

    /**
     * Get Show user agent controls
     */
    function getControls()
    {
        return $this->getAttribute("controls");
    }
}
