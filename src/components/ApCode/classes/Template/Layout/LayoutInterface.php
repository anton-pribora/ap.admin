<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout;

use ApCode\Template\Layout\Renderer\RendererInterface;

interface LayoutInterface
{
    function append($blockId, $value, $data = []);
    function appendOnce($blockId, $value, $data = []);
    function prepend($blockId, $value, $data = []);
    function prependOnce($blockId, $value, $data = []);
    
    function remove($blockId);
    function retrieve($blockId);
    function exists($blockId);

    function reset();

    function startGrab($blockId);
    function endGrab();

    function render($blockId, RendererInterface $renderer = NULL);
    function renderIfNotEmpty($blockId, RendererInterface $renderer = NULL);

    function setRenderer($blockId, RendererInterface $renderer);
    function setRendererIfEmpty($blockId, RendererInterface $renderer);

    function setVar($varname, $value);
    function getVar($varname, $default = NULL);
    function hasVar($varname);

    function display($returnAsString = NULL);
}