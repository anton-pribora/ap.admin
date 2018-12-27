<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web;

interface RequestInterface
{
    function id();
    function action();
    function setAction($action);
    function matchAction($path);
    
    function method();
    
    function has($varname);
    function get($varname, $default = null);
    function set($varname, $value);
}