<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Optgroup extends ContentableElement
{
    protected $tagName = 'optgroup';

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
}
