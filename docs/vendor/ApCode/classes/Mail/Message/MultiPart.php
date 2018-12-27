<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Message;

class MultiPart extends Part
{
    private $boundary = null;
    
    private $parts = [];
    
    public function __construct($type)
    {
        parent::__construct();
        $this->setContentType('multipart/'. $type .'; boundary="'. $this->getBoundary() .'"');
    }
    
    public function addPart(Part $part)
    {
        $this->parts[] = $part;
        return $this;
    }
    
    public function getContent()
    {
        $result = '';
        
        foreach ( $this->parts as $part ) {
            $result .= '--'. $this->getBoundary() ."\r\n";
            $result .= (string) $part ."\r\n";
        }
        
        $result .= '--'. $this->getBoundary() ."--\r\n\r\n";
        
        return $result;
    }
    
    public function getBoundary()
    {
        if ( is_null($this->boundary) ) {
            $this->boundary = str_pad(sha1(uniqid()), 46, '-', STR_PAD_LEFT);
        }
        
        return $this->boundary;
    }
    
    public function __toString()
    {
        return $this->headers ."\r\n". $this->getContent();
    }
}