<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Td extends ContentableElement
{
    protected $tagName = 'td';

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
     * Set The header cells for this cell
     * 
     * @param $value
     */
    function setHeaders($value)
    {
        $this->setAttribute("headers", $value);
        return $this;
    }

    /**
     * Get The header cells for this cell
     */
    function getHeaders()
    {
        return $this->getAttribute("headers");
    }
}
