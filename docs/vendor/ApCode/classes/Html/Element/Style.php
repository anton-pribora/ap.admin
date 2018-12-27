<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Style extends ContentableElement
{
    protected $tagName = 'style';
    
    protected $addHtmlInsteadOfText = true;
    
    protected function initialize()
    {
        $this->setType('text/css');
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
}
