<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Blockquote extends ContentableElement
{
    protected $tagName = 'blockquote';

    /**
     * Set Link to the source of the quotation.
     * 
     * @param $value
     */
    function setCite($value)
    {
        $this->setAttribute("cite", $value);
        return $this;
    }

    /**
     * Get Link to the source of the quotation.
     */
    function getCite()
    {
        return $this->getAttribute("cite");
    }
}
