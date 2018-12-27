<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Form extends ContentableElement
{
    protected $tagName = 'form';

    /**
     * Set Character encodings to use for form submission
     * 
     * @param $value
     */
    function setAcceptCharset($value)
    {
        $this->setAttribute("accept-charset", $value);
        return $this;
    }

    /**
     * Get Character encodings to use for form submission
     */
    function getAcceptCharset()
    {
        return $this->getAttribute("accept-charset");
    }

    /**
     * Set URL to use for form submission
     * 
     * @param $value
     */
    function setAction($value)
    {
        $this->setAttribute("action", $value);
        return $this;
    }

    /**
     * Get URL to use for form submission
     */
    function getAction()
    {
        return $this->getAttribute("action");
    }

    /**
     * Set Default setting for autofill feature for controls in the form
     * 
     * @param $value
     */
    function setAutocomplete($value)
    {
        $this->setAttribute("autocomplete", $value);
        return $this;
    }

    /**
     * Get Default setting for autofill feature for controls in the form
     */
    function getAutocomplete()
    {
        return $this->getAttribute("autocomplete");
    }

    /**
     * Set Form data set encoding type to use for form submission
     * 
     * @param $value
     */
    function setEnctype($value)
    {
        $this->setAttribute("enctype", $value);
        return $this;
    }

    /**
     * Get Form data set encoding type to use for form submission
     */
    function getEnctype()
    {
        return $this->getAttribute("enctype");
    }

    /**
     * Set HTTP method to use for form submission
     * 
     * @param $value
     */
    function setMethod($value)
    {
        $this->setAttribute("method", $value);
        return $this;
    }

    /**
     * Get HTTP method to use for form submission
     */
    function getMethod()
    {
        return $this->getAttribute("method");
    }

    /**
     * Set Name of form to use in the document.forms API
     * 
     * @param $value
     */
    function setName($value)
    {
        $this->setAttribute("name", $value);
        return $this;
    }

    /**
     * Get Name of form to use in the document.forms API
     */
    function getName()
    {
        return $this->getAttribute("name");
    }

    /**
     * Set Bypass form control validation for form submission
     * 
     * @param $value
     */
    function setNoValidate($value)
    {
        $this->setAttribute("novalidate", $value);
        return $this;
    }

    /**
     * Get Bypass form control validation for form submission
     */
    function getNoValidate()
    {
        return $this->getAttribute("novalidate");
    }

    /**
     * Set Browsing context for form submission
     * 
     * @param $value
     */
    function setTarget($value)
    {
        $this->setAttribute("target", $value);
        return $this;
    }

    /**
     * Get Browsing context for form submission
     */
    function getTarget()
    {
        return $this->getAttribute("target");
    }
}
