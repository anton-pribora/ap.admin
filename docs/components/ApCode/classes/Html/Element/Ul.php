<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Ul extends AbstractElement
{
    protected $tagName = 'ul';
    
    protected $alwaysCloseTag = true;

    public function createLi($contents = null)
    {
        $li = new Li($contents);
        $this->addSubElement($li);
        
        return $li;
    }
    
    /**
     * Set Number the list backwards.
     * 
     * @param $value
     */
    function setReversed($value)
    {
        $this->setAttribute("reversed", $value);
        return $this;
    }

    /**
     * Get Number the list backwards.
     */
    function getReversed()
    {
        return $this->getAttribute("reversed");
    }

    /**
     * Set Ordinal value of the first item
     * 
     * @param $value
     */
    function setStart($value)
    {
        $this->setAttribute("start", $value);
        return $this;
    }

    /**
     * Get Ordinal value of the first item
     */
    function getStart()
    {
        return $this->getAttribute("start");
    }

    /**
     * Set Kind of list marker.
     * 
     * @param $value
     */
    function setType($value)
    {
        $this->setAttribute("type", $value);
        return $this;
    }

    /**
     * Get Kind of list marker.
     */
    function getType()
    {
        return $this->getAttribute("type");
    }
}
