<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Label extends ContentableElement
{
    protected $tagName = 'label';

    /**
     * Set Associates the control with a form element
     * 
     * @param $value
     */
    function setForm($value)
    {
        $this->setAttribute("form", $value);
        return $this;
    }

    /**
     * Get Associates the control with a form element
     */
    function getForm()
    {
        return $this->getAttribute("form");
    }

    /**
     * Set Associate the label with form control
     * 
     * @param $value
     */
    function setFor($value)
    {
        $this->setAttribute("for", $value);
        return $this;
    }

    /**
     * Get Associate the label with form control
     */
    function getFor()
    {
        return $this->getAttribute("for");
    }
}
