<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Gotcha;

interface OptionsInterface
{
    function getOption($name, $default = NULL);
    function setOption($name, $value);
}