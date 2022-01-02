<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Tfoot extends AbstractElement
{
    protected $tagName = 'tfoot';
    
    public function createTr()
    {
        $tr = new Tr();
        $this->addSubElement($tr);
        
        return $tr;
    }
}
