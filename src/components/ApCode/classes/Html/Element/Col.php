<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Col extends AbstractElement
{
    protected $tagName = 'col';

    /**
     * Set Number of columns spanned by the element
     * 
     * @param $value
     */
    function setSpan($value)
    {
        $this->setAttribute("span", $value);
        return $this;
    }

    /**
     * Get Number of columns spanned by the element
     */
    function getSpan()
    {
        return $this->getAttribute("span");
    }
}
