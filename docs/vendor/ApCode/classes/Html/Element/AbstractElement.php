<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

use ApCode\Xml\Element;

abstract class AbstractElement extends Element
{
    /**
     * @return self|static
     */
    public static function factory(...$params)
    {
        return new static(...$params);
    }
    
    /**
     * @return Div
     */
    public function createDiv(...$params)
    {
        return $this->createSubElement('div', ...$params);
    }
    
    /**
     * @return A
     */
    public function createA(...$params)
    {
        return $this->createSubElement('a', ...$params);
    }
    
    /**
     * @return Img
     */
    public function createImg(...$params)
    {
        return $this->createSubElement('img', ...$params);
    }
    
    /**
     * @return Span
     */
    public function createSpan(...$params)
    {
        return $this->createSubElement('span', ...$params);
    }
    
    public function setId($id)
    {
        $this->setAttribute('id', $id);
        return $this;
    }
    
    public function getId()
    {
        return $this->getAttribute('id');
    }
    
    public function getOrGenerateId()
    {
        if ( !$this->hasAttribute('id') ) {
            $this->generateId();
        }
        
        return $this->getId();
    }
    
    private function generateId()
    {
        static $classes = [];
        
        $class = get_class($this);
        $class = preg_replace('~.*\\\\~', '', $class);
        
        if ( !isset($classes[ $class ]) ) {
            $classes[ $class ] = 1;
        }
        
        $position = $classes[ $class ]++;
        
        $this->setId($class . $position);
    }
    
    public function setTitle($title)
    {
        $this->setAttribute('title', $title);
        return $this;
    }
    
    public function setLang($lang)
    {
        $this->setAttribute('lang', $lang);
        return $this;
    }
    
    public function onclick(... $onclick)
    {
        return $this->setAttribute('onclick', join('; ', $onclick));
    }
    
    public function onclickConfirm($text, $agree = null, $disagree = null)
    {
        $result   = [];
        $result[] = 'if (confirm('. json_encode($text, JSON_UNESCAPED_UNICODE) .'))';
        
        if ( isset($agree) ) {
            $result[] = rtrim($agree, '; ');
        }
        
        if ( isset($disagree) ) {
            $result[] = '; else ';
            $result[] = $disagree;
        }
        
        return $this->onclick(join($result));
    }
    
    public function onchange(... $onchange)
    {
        return $this->setAttribute('onchange', join('; ', $onchange));
    }
    
    public function addStyle($style)
    {
        if ( isset($this->attributes['style']) )
        {
            $this->attributes['style'] .= '; '. trim($style, '; ');
        }
        else
        {
            $this->attributes['style'] = trim($style, '; ');
        }
        
        return $this;
    }
    
    public function setClass($class)
    {
        $this->setAttribute('class', $class);
        return $this;
    }
    
    public function getClass()
    {
        return $this->getAttribute('class');
    }
    
    public function addClass($class)
    {
        if ( isset($this->attributes['class']) )
        {
            $this->attributes['class'] .= ' '. trim($class);
        }
        else
        {
            $this->attributes['class'] = trim($class);
        }
        
        return $this;
    }
    
    public function removeClass($class)
    {
        $pattern = '/\b'. strtr(preg_quote($class), ['*' => 'S*']) .'\b/';
        
        $result = $this->getAttribute('class', '');
        $result = preg_replace($pattern, '', $result);
        $result = preg_replace('/\s{2,}/', ' ', $result);
        $result = trim($result);
        
        $this->setClass($result);
    }
    
    public function hasClass($class)
    {
        $pattern = '/\b'. strtr(preg_quote($class), ['*' => 'S*']) .'\b/';
        return (bool) preg_match($pattern, $this->getClass());
    }
    
    /**
     * 
     * @return AbstractElement
     */
    public function createSubElement($class, ...$args)
    {
        if ( strpos($class, '\\') === false )
        {
            $class = __NAMESPACE__ .'\\'. ucfirst($class);
        }
        
        return parent::createSubElement($class, ...$args);
    }
    
    /**
     * Возвращает список дочерних элементов
     * @return AbstractElement[]
     */
    public function getSubElements()
    {
        return $this->subElements;
    }
}