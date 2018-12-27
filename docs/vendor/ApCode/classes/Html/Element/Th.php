<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Th extends ContentableElement
{
    protected $tagName = 'th';

    /**
     * Set Number of columns that the cell is to span
     * 
     * @param $value
     */
    function setColspan($value)
    {
        $this->setAttribute("colspan", $value);
        return $this;
    }

    /**
     * Get Number of columns that the cell is to span
     */
    function getColspan()
    {
        return $this->getAttribute("colspan");
    }

    /**
     * Set Number of rows that the cell is to span
     * 
     * @param $value
     */
    function setRowspan($value)
    {
        $this->setAttribute("rowspan", $value);
        return $this;
    }

    /**
     * Get Number of rows that the cell is to span
     */
    function getRowspan()
    {
        return $this->getAttribute("rowspan");
    }

    /**
     * Set The headers for this cell
     * 
     * @param $value
     */
    function setHeaders($value)
    {
        $this->setAttribute("headers", $value);
        return $this;
    }

    /**
     * Get The headers for this cell
     */
    function getHeaders()
    {
        return $this->getAttribute("headers");
    }

    /**
     * Set Specifies which cells the header cell applies to
     * 
     * @param $value
     */
    function setScope($value)
    {
        $this->setAttribute("scope", $value);
        return $this;
    }

    /**
     * Get Specifies which cells the header cell applies to
     */
    function getScope()
    {
        return $this->getAttribute("scope");
    }

    /**
     * Set Alternative label to use for the header cell when referencing the cell in other contexts
     * 
     * @param $value
     */
    function setAbbr($value)
    {
        $this->setAttribute("abbr", $value);
        return $this;
    }

    /**
     * Get Alternative label to use for the header cell when referencing the cell in other contexts
     */
    function getAbbr()
    {
        return $this->getAttribute("abbr");
    }

    /**
     * Set Column sort direction and ordinality
     * 
     * @param $value
     */
    function setSorted($value)
    {
        $this->setAttribute("sorted", $value);
        return $this;
    }

    /**
     * Get Column sort direction and ordinality
     */
    function getSorted()
    {
        return $this->getAttribute("sorted");
    }
}
