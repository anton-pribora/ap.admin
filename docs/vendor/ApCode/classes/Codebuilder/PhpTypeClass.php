<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpTypeClass extends PhpType
{
    public function __construct(PhpInterface $class)
    {
        $this->value = $class;
    }
    
    public function render()
    {
        return $this->value->getFullName();
    }
}