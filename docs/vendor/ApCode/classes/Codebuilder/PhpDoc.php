<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpDoc
{
    protected $body = [];
    
    protected $keywords = [];
    
    public function addBody($array)
    {
        foreach ( $array as $line )
        {
            $this->addBodyLine($line);
        }
        
        return $this;
    }
    
    public function addBodyLine($line)
    {
        $this->body[] = $line;
        return $this;
    }
    
    public function hasBody()
    {
        return count($this->body) > 0;
    }
    
    public function getBodyLines()
    {
        return $this->body;
    }
    
    public function addKeyword($name, $value = null)
    {
        $this->keywords[] = new PhpDocKeyword($name, $value);
        return $this;
    }
    
    public function addKeywordParam($name, $type = null, $description = null)
    {
        $value = [];
        
        if ( $type )
        {
            $value[] = $type;
        }
        
        $value[] = '$'. $name;
        
        if ( $description )
        {
            $value[] = $description;
        }
        
        $this->addKeyword('param', join(' ', $value));
        return $this;
    }
    
    public function addKeywordReturn($type)
    {
        $this->addKeyword('return', $type);
        return $this;
    }
    
    public function hasKeywords()
    {
        return count($this->keywords) > 0;
    }
    
    public function getKeywords()
    {
        return $this->keywords;
    }
    
    public function hasContents()
    {
        return $this->hasBody() || $this->hasKeywords();
    }
    
    public function toArray()
    {
        $result   = [];
        $result[] = '/**';
        
        foreach ( $this->body as $line )
        {
            $result[] = ' * '. $line;
        }
        
        if ( $this->hasKeywords() )
        {
            $result[] = ' * ';
            
            foreach ( $this->keywords as $keyword )
            {
                $result[] = ' * @'. $keyword->getName() .' '. $keyword->getValue();
            }
        }
        
        $result[] = ' */';
        
        return $result;
    }
}