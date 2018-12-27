<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Base extends AbstractElement
{
    protected $tagName = 'base';

    /**
     * Set Document base URL
     * 
     * @param $value
     */
    function setHref($value)
    {
        $this->setAttribute("href", $value);
        return $this;
    }

    /**
     * Get Document base URL
     */
    function getHref()
    {
        return $this->getAttribute("href");
    }

    /**
     * Set Default browsing context for hyperlink navigation and form submission
     * 
     * @param $value
     */
    function setTarget($value)
    {
        $this->setAttribute("target", $value);
        return $this;
    }

    /**
     * Get Default browsing context for hyperlink navigation and form submission
     */
    function getTarget()
    {
        return $this->getAttribute("target");
    }
}
