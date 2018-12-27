<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Input extends AbstractElement
{
    protected $tagName = 'input';

    public function __construct($value = null, $name = null, $type = NULL)
    {
        $this->setValue($value);
        $this->setName($name);
        $this->setType($type);
    }
    
    /**
     * Set Hint for expected file type in file upload controls
     * 
     * @param $value
     */
    function setAccept($value)
    {
        $this->setAttribute("accept", $value);
        return $this;
    }

    /**
     * Get Hint for expected file type in file upload controls
     */
    function getAccept()
    {
        return $this->getAttribute("accept");
    }

    /**
     * Set Replacement text for use when images are not available
     * 
     * @param $value
     */
    function setAlt($value)
    {
        $this->setAttribute("alt", $value);
        return $this;
    }

    /**
     * Get Replacement text for use when images are not available
     */
    function getAlt()
    {
        return $this->getAttribute("alt");
    }

    /**
     * Set Hint for form autofill feature
     * 
     * @param $value
     */
    function setAutocomplete($value)
    {
        $this->setAttribute("autocomplete", $value);
        return $this;
    }

    /**
     * Get Hint for form autofill feature
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
     * Set Whether the command or control is checked
     * 
     * @param $value
     */
    function setChecked($value)
    {
        $this->setAttribute("checked", $value);
        return $this;
    }

    /**
     * Get Whether the command or control is checked
     */
    function getChecked()
    {
        return $this->getAttribute("checked");
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
     * Set Vertical dimension
     * 
     * @param $value
     */
    function setHeight($value)
    {
        $this->setAttribute("height", $value);
        return $this;
    }

    /**
     * Get Vertical dimension
     */
    function getHeight()
    {
        return $this->getAttribute("height");
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
     * Set List of autocomplete options
     * 
     * @param $value
     */
    function setList($value)
    {
        $this->setAttribute("list", $value);
        return $this;
    }

    /**
     * Get List of autocomplete options
     */
    function getList()
    {
        return $this->getAttribute("list");
    }

    /**
     * Set Maximum value
     * 
     * @param $value
     */
    function setMax($value)
    {
        $this->setAttribute("max", $value);
        return $this;
    }

    /**
     * Get Maximum value
     */
    function getMax()
    {
        return $this->getAttribute("max");
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
     * Set Minimum value
     * 
     * @param $value
     */
    function setMin($value)
    {
        $this->setAttribute("min", $value);
        return $this;
    }

    /**
     * Get Minimum value
     */
    function getMin()
    {
        return $this->getAttribute("min");
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
     * Set Whether to allow multiple values
     * 
     * @param $value
     */
    function setMultiple($value)
    {
        $this->setAttribute("multiple", $value);
        return $this;
    }

    /**
     * Get Whether to allow multiple values
     */
    function getMultiple()
    {
        return $this->getAttribute("multiple");
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
     * Set Pattern to be matched by the form control's value
     * 
     * @param $value
     */
    function setPattern($value)
    {
        $this->setAttribute("pattern", $value);
        return $this;
    }

    /**
     * Get Pattern to be matched by the form control's value
     */
    function getPattern()
    {
        return $this->getAttribute("pattern");
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
     * Set Size of the control
     * 
     * @param $value
     */
    function setSize($value)
    {
        $this->setAttribute("size", $value);
        return $this;
    }

    /**
     * Get Size of the control
     */
    function getSize()
    {
        return $this->getAttribute("size");
    }

    /**
     * Set Address of the resource
     * 
     * @param $value
     */
    function setSrc($value)
    {
        $this->setAttribute("src", $value);
        return $this;
    }

    /**
     * Get Address of the resource
     */
    function getSrc()
    {
        return $this->getAttribute("src");
    }

    /**
     * Set Granularity to be matched by the form control's value
     * 
     * @param $value
     */
    function setStep($value)
    {
        $this->setAttribute("step", $value);
        return $this;
    }

    /**
     * Get Granularity to be matched by the form control's value
     */
    function getStep()
    {
        return $this->getAttribute("step");
    }

    /**
     * Set Type of form control
     * 
     * @param $value
     */
    function setType($value)
    {
        $this->setAttribute("type", $value);
        return $this;
    }

    /**
     * Get Type of form control
     */
    function getType()
    {
        return $this->getAttribute("type");
    }

    /**
     * Set Value of the form control
     * 
     * @param $value
     */
    function setValue($value)
    {
        $this->setAttribute("value", $value);
        return $this;
    }

    /**
     * Get Value of the form control
     */
    function getValue()
    {
        return $this->getAttribute("value");
    }

    /**
     * Set Horizontal dimension
     * 
     * @param $value
     */
    function setWidth($value)
    {
        $this->setAttribute("width", $value);
        return $this;
    }

    /**
     * Get Horizontal dimension
     */
    function getWidth()
    {
        return $this->getAttribute("width");
    }
}
