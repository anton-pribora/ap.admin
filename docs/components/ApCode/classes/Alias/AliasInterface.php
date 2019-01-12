<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Alias;

interface AliasInterface
{
    function has($alias);
    function set($alias, $value);
    function append($alias, $value);
    function get($alias);
    function expand($alias);
}