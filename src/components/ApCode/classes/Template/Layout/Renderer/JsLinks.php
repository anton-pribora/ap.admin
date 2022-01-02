<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout\Renderer;

class JsLinks implements RendererInterface
{
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderValue()
     */
    public function renderValue($value, $data)
    {
        $attributes = array_merge(['type' => 'text/javascript', 'src' => $value], $data);
        
        $result = '<script';
        
        foreach ($attributes as $name => $value) {
            $result .= " $name=\"$value\"";
        }
        
        return $result .'></script>';
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