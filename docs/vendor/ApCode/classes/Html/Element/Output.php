<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Output extends ContentableElement
{
    protected $tagName = 'output';

    /**
     * Set Specifies controls from which the output was calculated
     * 
     * @param $value
     */
    function setFor($value)
    {
        $this->setAttribute("for", $value);
        return $this;
    }

    /**
     * Get Specifies controls from which the output was calculated
     */
    function getFor()
    {
        return $this->getAttribute("for");
    }

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
     * Set Name of form control to use for form submission and in the form.elements API
     * 
     * @param $value
     */
    function setName($value)
    {
        $this->setAttribute("name", $value);
        return $this;
    }

    /**
     * Get Name of form control to use for form submission and in the form.elements API
     */
    function getName()
    {
        return $this->getAttribute("name");
    }
}
