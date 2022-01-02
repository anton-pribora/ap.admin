<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout\Renderer;

class Tag implements RendererInterface
{
    private $tag;
    private $separator;
    private $attributes;
    
    public function __construct($tag, $separator = '', $attributes = [])
    {
        $this->tag = $tag;
        $this->separator = $separator;
        $this->attributes = $attributes;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderValue()
     */
    public function renderValue($value, $data)
    {
        return $value;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderResult()
     */
    public function renderResult($values)
    {
        $result = "<$this->tag";
        
        if ($this->attributes) {
            foreach ($this->attributes as $name => $value) {
                $result .= " $name=\"$value\"";
            }
        }
        
        return $result .">". join($this->separator, $values) ."</$this->tag>";
    }
}