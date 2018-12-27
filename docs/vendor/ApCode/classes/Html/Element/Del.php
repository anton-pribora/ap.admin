<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Del extends ContentableElement
{
    protected $tagName = 'del';

    /**
     * Set Link to the source of the quotation or more information about the edit
     * 
     * @param $value
     */
    function setCite($value)
    {
        $this->setAttribute("cite", $value);
        return $this;
    }

    /**
     * Get Link to the source of the quotation or more information about the edit
     */
    function getCite()
    {
        return $this->getAttribute("cite");
    }

    /**
     * Set Date and (optionally) time of the change
     * 
     * @param $value
     */
    function setDatetime($value)
    {
        $this->setAttribute("datetime", $value);
        return $this;
    }

    /**
     * Get Date and (optionally) time of the change
     */
    function getDatetime()
    {
        return $this->getAttribute("datetime");
    }
}
