<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Map extends ContentableElement
{
    protected $tagName = 'map';

    /**
     * Set Name of image map to reference from the usemap attribute
     * 
     * @param $value
     */
    function setName($value)
    {
        $this->setAttribute("name", $value);
        return $this;
    }

    /**
     * Get Name of image map to reference from the usemap attribute
     */
    function getName()
    {
        return $this->getAttribute("name");
    }
}
