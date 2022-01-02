<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Head extends ContentableElement
{
    protected $tagName = 'head';
    
    /**
     * 
     * @var HeadTitle
     */
    protected $title = null;
    
    protected function initialize()
    {
        $this->title = $this->createSubElement(Title::class);
    }
    
    /**
     * 
     * @return Title
     */
    public function title()
    {
        return $this->title;
    }
}
