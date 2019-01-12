<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout\Renderer;

class Callback implements RendererInterface
{
    private $renderValue;
    private $renderResult;
    
    public function __construct(callable $renderValue, callable $renderResult)
    {
        $this->renderValue  = $renderValue;
        $this->renderResult = $renderResult;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderValue()
     */
    public function renderValue($value, $data)
    {
        return call_user_func($this->renderValue, $value, $data);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderResult()
     */
    public function renderResult($values)
    {
        return call_user_func($this->renderResult, $values);
    }
}