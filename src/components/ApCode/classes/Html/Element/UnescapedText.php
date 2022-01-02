<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class UnescapedText extends ContentableElement
{
    protected $text = null;

    public function addContents($contents)
    {
        $this->text .= (string) $contents;
        return $this;
    }
    
    public function hasContents()
    {
        return strlen($this->text) > 0;
    }
    
    public function __toString()
    {
        return (string) $this->text;
    }
}