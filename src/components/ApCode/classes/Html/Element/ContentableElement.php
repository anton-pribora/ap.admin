<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class ContentableElement extends AbstractElement
{
    protected $alwaysCloseTag = true;

    protected $addHtmlInsteadOfText = false;

    public function __construct($contents = null)
    {
        if ( isset($contents) )
        {
            $this->addContents($contents);
        }

        parent::__construct();
    }

    public function setContents($contents)
    {
        $this->removeSubElements();
        return $this->addContents($contents);
    }

    public function addContents($contents)
    {
        if ( is_array($contents) )
        {
            foreach ( $contents as $item )
            {
                $this->addContents($item);
            }
        }
        elseif ( !$contents instanceof AbstractElement )
        {
            if ( $this->addHtmlInsteadOfText )
            {
                $this->addHtml((string) $contents);
            }
            else
            {
                $this->addText((string) $contents);
            }
        }
        else
        {
            $this->addSubElement($contents);
        }

        return $this;
    }

    public function hasContents()
    {
        return count($this->subElements) > 0;
    }

    protected function addText($text)
    {
        $this->createSubElement(EscapedText::class, $text);
        return $this;
    }

    protected function addHtml($html)
    {
        $this->createSubElement(UnescapedText::class, $html);
        return $this;
    }
}
