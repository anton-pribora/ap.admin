<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Meter extends ContentableElement
{
    protected $tagName = 'meter';

    /**
     * Set Current value of the element
     * 
     * @param $value
     */
    function setValue($value)
    {
        $this->setAttribute("value", $value);
        return $this;
    }

    /**
     * Get Current value of the element
     */
    function getValue()
    {
        return $this->getAttribute("value");
    }

    /**
     * Set Lower bound of range
     * 
     * @param $value
     */
    function setMin($value)
    {
        $this->setAttribute("min", $value);
        return $this;
    }

    /**
     * Get Lower bound of range
     */
    function getMin()
    {
        return $this->getAttribute("min");
    }

    /**
     * Set Upper bound of range
     * 
     * @param $value
     */
    function setMax($value)
    {
        $this->setAttribute("max", $value);
        return $this;
    }

    /**
     * Get Upper bound of range
     */
    function getMax()
    {
        return $this->getAttribute("max");
    }

    /**
     * Set High limit of low range
     * 
     * @param $value
     */
    function setLow($value)
    {
        $this->setAttribute("low", $value);
        return $this;
    }

    /**
     * Get High limit of low range
     */
    function getLow()
    {
        return $this->getAttribute("low");
    }

    /**
     * Set Low limit of high range
     * 
     * @param $value
     */
    function setHigh($value)
    {
        $this->setAttribute("high", $value);
        return $this;
    }

    /**
     * Get Low limit of high range
     */
    function getHigh()
    {
        return $this->getAttribute("high");
    }

    /**
     * Set Optimum value in gauge
     * 
     * @param $value
     */
    function setOptimum($value)
    {
        $this->setAttribute("optimum", $value);
        return $this;
    }

    /**
     * Get Optimum value in gauge
     */
    function getOptimum()
    {
        return $this->getAttribute("optimum");
    }
}
