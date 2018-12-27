<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpValueSingleQuoteString extends PhpValue
{
    public function __toString()
    {
        return "'". addcslashes($this->value, "'\\") ."'";
    }
}