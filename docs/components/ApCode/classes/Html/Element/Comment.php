<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Comment extends ContentableElement
{
    protected $addHtmlInsteadOfText = true;
    
    public function __toString()
    {
        return '<!-- '. $this->getContents() .' -->';
    }
}