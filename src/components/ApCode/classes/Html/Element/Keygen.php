<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Keygen extends AbstractElement
{
    protected $tagName = 'keygen';

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
     * Set String to package with the generated and signed public key
     * 
     * @param $value
     */
    function setChallenge($value)
    {
        $this->setAttribute("challenge", $value);
        return $this;
    }

    /**
     * Get String to package with the generated and signed public key
     */
    function getChallenge()
    {
        return $this->getAttribute("challenge");
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
     * Set The type of cryptographic key to generate
     * 
     * @param $value
     */
    function setKeytype($value)
    {
        $this->setAttribute("keytype", $value);
        return $this;
    }

    /**
     * Get The type of cryptographic key to generate
     */
    function getKeytype()
    {
        return $this->getAttribute("keytype");
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
