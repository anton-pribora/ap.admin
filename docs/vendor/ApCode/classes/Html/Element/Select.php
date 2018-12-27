<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

use Library\Xml\Element;
class Select extends AbstractElement
{
    protected $tagName = 'select';

    protected $alwaysCloseTag = true;
    
    public function __construct($name = null)
    {
        if ( isset($name) ) {
            $this->setName($name);
        }
        
        parent::__construct();
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
    
    public function createOption($text = null, $value = null, $selected = null)
    {
        $option = $this->createSubElement('option', $text);
        
        if ( isset($value) ) {
            $option->setValue($value);
        }
        
        if ( $selected ) {
            $option->setAttribute('selected', 'selected');
        }
        
        return $option;
    }
    
    public function createOptions($options)
    {
        foreach ( $options as $value => $name ) {
            $this->createOption($name, $value);
        }
        
        return $this;
    }
    
    public function getOptions()
    {
        return $this->subElements;
    }
    
    /**
     * Устанавливает аттрибут selected для опции с соответствующим значением
     * 
     * @param string $value
     * @return \Library\Html\Element\Select
     */
    public function setValue($value)
    {
        foreach ($this->getSubElements() as $option) {
            if ($option->getValue() == $value) {
                $option->setSelected('selected');
            }
            else {
                $option->removeAttribute('selected');
            }
        }
        
        return $this;
    }
    
    public function getValue()
    {
        foreach ($this->getSubElements() as $option) {
            if ( $option->getAttribute('selected') == 'selected' ) {
                return $option->getValue();
            }
        }
        
        return null;
    }
}
