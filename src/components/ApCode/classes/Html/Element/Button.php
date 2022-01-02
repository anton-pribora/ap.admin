<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Button extends ContentableElement
{
    protected $tagName = 'button';

    /**
     * Set Automatically focus the form control when the page is loaded
     * 
     * @param $value
     */
    function setAutofocus($value)
    {
        $this->setAttribute("autofocus", $value);
        return $this;
    }

    /**
     * Get Automatically focus the form control when the page is loaded
     */
    function getAutofocus()
    {
        return $this->getAttribute("autofocus");
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
     * Set URL to use for form submission
     * 
     * @param $value
     */
    function setFormAction($value)
    {
        $this->setAttribute("formaction", $value);
        return $this;
    }

    /**
     * Get URL to use for form submission
     */
    function getFormAction()
    {
        return $this->getAttribute("formaction");
    }

    /**
     * Set Form data set encoding type to use for form submission
     * 
     * @param $value
     */
    function setFormEnctype($value)
    {
        $this->setAttribute("formenctype", $value);
        return $this;
    }

    /**
     * Get Form data set encoding type to use for form submission
     */
    function getFormEnctype()
    {
        return $this->getAttribute("formenctype");
    }

    /**
     * Set HTTP method to use for form submission
     * 
     * @param $value
     */
    function setFormMethod($value)
    {
        $this->setAttribute("formmethod", $value);
        return $this;
    }

    /**
     * Get HTTP method to use for form submission
     */
    function getFormMethod()
    {
        return $this->getAttribute("formmethod");
    }

    /**
     * Set Bypass form control validation for form submission
     * 
     * @param $value
     */
    function setFormNoValidate($value)
    {
        $this->setAttribute("formnovalidate", $value);
        return $this;
    }

    /**
     * Get Bypass form control validation for form submission
     */
    function getFormNoValidate()
    {
        return $this->getAttribute("formnovalidate");
    }

    /**
     * Set Browsing context for form submission
     * 
     * @param $value
     */
    function setFormTarget($value)
    {
        $this->setAttribute("formtarget", $value);
        return $this;
    }

    /**
     * Get Browsing context for form submission
     */
    function getFormTarget()
    {
        return $this->getAttribute("formtarget");
    }

    /**
     * Set Specifies the element's designated pop-up menu
     * 
     * @param $value
     */
    function setMenu($value)
    {
        $this->setAttribute("menu", $value);
        return $this;
    }

    /**
     * Get Specifies the element's designated pop-up menu
     */
    function getMenu()
    {
        return $this->getAttribute("menu");
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

    /**
     * Set Type of button
     * 
     * @param $value
     */
    function setType($value)
    {
        $this->setAttribute("type", $value);
        return $this;
    }

    /**
     * Get Type of button
     */
    function getType()
    {
        return $this->getAttribute("type");
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
