<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Textarea extends ContentableElement
{
    protected $tagName = 'textarea';

    public function __construct($conetnts = null, $name = null)
    {
        parent::__construct($conetnts);
        
        if ( isset($name) ) {
            $this->setName($name);
        }
    }
    
    /**
     * Set - Hint for form autofill feature
     * 
     * @param $value
     */
    function setAutocomplete($value)
    {
        $this->setAttribute("autocomplete", $value);
        return $this;
    }

    /**
     * Get - Hint for form autofill feature
     */
    function getAutocomplete()
    {
        return $this->getAttribute("autocomplete");
    }

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
     * Set Maximum number of characters per line
     * 
     * @param $value
     */
    function setCols($value)
    {
        $this->setAttribute("cols", $value);
        return $this;
    }

    /**
     * Get Maximum number of characters per line
     */
    function getCols()
    {
        return $this->getAttribute("cols");
    }

    /**
     * Set Name of form field to use for sending the element's directionality in form submission
     * 
     * @param $value
     */
    function setDirName($value)
    {
        $this->setAttribute("dirname", $value);
        return $this;
    }

    /**
     * Get Name of form field to use for sending the element's directionality in form submission
     */
    function getDirName()
    {
        return $this->getAttribute("dirname");
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
     * Set Hint for selecting an input modality
     * 
     * @param $value
     */
    function setInputmode($value)
    {
        $this->setAttribute("inputmode", $value);
        return $this;
    }

    /**
     * Get Hint for selecting an input modality
     */
    function getInputmode()
    {
        return $this->getAttribute("inputmode");
    }

    /**
     * Set Maximum length of value
     * 
     * @param $value
     */
    function setMaxLength($value)
    {
        $this->setAttribute("maxlength", $value);
        return $this;
    }

    /**
     * Get Maximum length of value
     */
    function getMaxLength()
    {
        return $this->getAttribute("maxlength");
    }

    /**
     * Set Minimum length of value
     * 
     * @param $value
     */
    function setMinLength($value)
    {
        $this->setAttribute("minlength", $value);
        return $this;
    }

    /**
     * Get Minimum length of value
     */
    function getMinLength()
    {
        return $this->getAttribute("minlength");
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
     * Set User-visible label to be placed within the form control
     * 
     * @param $value
     */
    function setPlaceholder($value)
    {
        $this->setAttribute("placeholder", $value);
        return $this;
    }

    /**
     * Get User-visible label to be placed within the form control
     */
    function getPlaceholder()
    {
        return $this->getAttribute("placeholder");
    }

    /**
     * Set Whether to allow the value to be edited by the user
     * 
     * @param $value
     */
    function setReadOnly($value)
    {
        $this->setAttribute("readonly", $value);
        return $this;
    }

    /**
     * Get Whether to allow the value to be edited by the user
     */
    function getReadOnly()
    {
        return $this->getAttribute("readonly");
    }

    /**
     * Set Whether the control is required for form submission
     * 
     * @param $value
     */
    function setRequired($value)
    {
        $this->setAttribute("required", $value);
        return $this;
    }

    /**
     * Get Whether the control is required for form submission
     */
    function getRequired()
    {
        return $this->getAttribute("required");
    }

    /**
     * Set Number of lines to show
     * 
     * @param $value
     */
    function setRows($value)
    {
        $this->setAttribute("rows", $value);
        return $this;
    }

    /**
     * Get Number of lines to show
     */
    function getRows()
    {
        return $this->getAttribute("rows");
    }

    /**
     * Set How the value of the form control is to be wrapped for form submission
     * 
     * @param $value
     */
    function setWrap($value)
    {
        $this->setAttribute("wrap", $value);
        return $this;
    }

    /**
     * Get How the value of the form control is to be wrapped for form submission
     */
    function getWrap()
    {
        return $this->getAttribute("wrap");
    }
}
