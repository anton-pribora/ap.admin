<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Tr extends AbstractElement
{
    protected $tagName = 'tr';
    
    public function createTh($contents = null)
    {
        $th = new Th($contents);
        $this->addSubElement($th);
        
        return $th;
    }
    
    public function createTd($contents = null)
    {
        $td = new Td($contents);
        $this->addSubElement($td);
        
        return $td;
    }
}
