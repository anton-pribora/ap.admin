<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout\Renderer;

class JsCdn implements RendererInterface
{
    private $basePath;
    
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
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
        return '<script type="text/javascript" src="'. $this->basePath . join(",", $values) .'.js"></script>';
    }
}