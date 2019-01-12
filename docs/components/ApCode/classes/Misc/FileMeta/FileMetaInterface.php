<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Misc\FileMeta;

interface FileMetaInterface
{
    function metaFileName();
    
    function has($name);
    function get($name, $default = NULL);
    function set($name, $value);
}