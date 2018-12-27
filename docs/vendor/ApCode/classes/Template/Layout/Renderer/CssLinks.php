<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout\Renderer;

class CssLinks implements RendererInterface
{
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderValue()
     */
    public function renderValue($value, $data)
    {
        $attributes = array_merge(['rel' => 'stylesheet', 'href' => $value], $data);
        
        $result = '<link';
        
        foreach ($attributes as $name => $value) {
            $result .= " $name=\"$value\"";
        }
        
        return $result .' />';
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderResult()
     */
    public function renderResult($values)
    {
        return join("\n", $values);
    }
}