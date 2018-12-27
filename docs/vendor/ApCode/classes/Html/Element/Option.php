<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Option extends ContentableElement
{
    protected $tagName = 'option';

    public function __construct($text = null, $value = null)
    {
        if ( isset($value) ) {
            $this->setValue($value);
        }
        
        parent::__construct($text);
    }
    
    /**
     * Set Whether the form control is disabled
     * 
     * @param $value
     */
    function setDisabled($value)
    {
        $this->setAttribute("disabled", $value);
        return $this;
    }

    /**
     * Get Whether the form control is disabled
     */
    function getDisabled()
    {
        return $this->getAttribute("disabled");
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
     * Set Whether the option is selected by default
     * 
     * @param $value
     */
    function setSelected($value)
    {
        $this->setAttribute("selected", $value);
        return $this;
    }

    /**
     * Get Whether the option is selected by default
     */
    function getSelected()
    {
        return $this->getAttribute("selected");
    }

    /**
     * Set Value to be used for form submission
     * 
     * @param $value
     */
    function setValue($value)
    {
        $this->setAttribute("value", $value);
        return $this;
    }

    /**
     * Get Value to be used for form submission
     */
    function getValue()
    {
        return $this->getAttribute("value");
    }
}
