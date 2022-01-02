<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

class BasicData
{
    protected $data;
    
    public function __construct(&$data)
    {
        $this->data = &$data;
    }
}