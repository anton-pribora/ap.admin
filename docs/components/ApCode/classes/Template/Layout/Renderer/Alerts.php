<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout\Renderer;

class Alerts implements RendererInterface
{
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderValue()
     */
    public function renderValue($value, $data)
    {
        return '<div class="alert alert-'.($data ?: 'warning').'"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>'. $value .'</div>';
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\Renderer\RendererInterface::renderResult()
     */
    public function renderResult($values)
    {
        // TODO Auto-generated method stub
        return join($values);
    }
}