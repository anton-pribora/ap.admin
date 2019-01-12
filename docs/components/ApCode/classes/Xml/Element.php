<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Xml;

class Element
{
    protected $tagName = null;
    
    protected $attributes = [];
    
    protected $subElements = [];
    
    protected $alwaysCloseTag = null;
    
    public function __construct()
    {
        $this->initialize();
    }
    
    protected function initialize()
    {
    }
    
    public function setAttribute($key, $value)
    {
        if (isset($value)) {
            $this->attributes[ $key ] = $value;
        }
        else {
            $this->removeAttribute($key);
        }
        
        return $this;
    }
    
    public function removeAttribute($key)
    {
        unset($this->attributes[ $key ]);
        return $this;
    }
    
    public function getAttribute($key, $default = null)
    {
        return isset($this->attributes[ $key ]) ? $this->attributes[ $key ] : $default;
    }
    
    public function removeSubElements()
    {
        $this->subElements = [];
        return $this;
    }
    
    public function createSubElement($class, ...$args)
    {
        $element = new $class(...$args);
        $this->addSubElement($element);
        return $element;
    }
    
    public function addSubElement(Element $subElement)
    {
        $this->subElements[] = $subElement;
        return $this;
    }
    
    public function addSubElements($subElements)
    {
        foreach ($subElements as $subElement) {
            $this->addSubElement($subElement);
        }
        
        return $this;
    }
    
    public function getTagName() 
    {
        return $this->tagName;
    }
    
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;
        return $this;
    }
    
    public function hasSubElements() 
    {
        return count($this->subElements) > 0;
    }
    
    public function hasAttributes()
    {
        return count($this->attributes) > 0;
    }
    
    public function hasAttribute($attribute)
    {
        return isset($this->attributes[ $attribute ]);
    }
    
    public function getContents() 
    {
        $result = '';
        
        foreach ($this->subElements as $subElement) {
            $result .= (string) $subElement;
        }
        
        return $result;
    }
    
    public function getSubElements()
    {
        return $this->subElements;
    }
    
    public function __toString()
    {
        $result = '<'. $this->tagName;
        
        if ($this->hasAttributes() ) {
            foreach ($this->attributes as $name => $value) {
                $result .= ' '. $name .'="'. Xml::escape($value) .'"';
            }
        }
        
        if ($this->hasSubElements() || $this->alwaysCloseTag) {
            $result .= '>'. $this->getContents() .'</'. $this->tagName .'>';
        }
        else {
            $result .= '/>';
        }
        
        return $result;
    }
}