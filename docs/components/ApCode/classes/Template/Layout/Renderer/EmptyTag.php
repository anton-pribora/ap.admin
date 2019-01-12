<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout\Renderer;

class EmptyTag implements RendererInterface
{
    private $tag;
    private $separator;
    
    public function __construct($tag, $separator = '')
    {
        $this->tag = $tag;
        $this->separator = $separator;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderValue()
     */
    public function renderValue($value, $data)
    {
        $result = "<$this->tag";
        
        if (is_array($value)) {
            foreach ($value as $attr => $val) {
                $result .= " $attr=\"$val\"";
            }
        }
        
        return $result .'>';
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderResult()
     */
    public function renderResult($values)
    {
        return join($this->separator, $values);
    }
}