<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Message;

class Headers
{
    private $storage = [];
    
    public function set($header, $value, $encodeValue = false)
    {
        if ( $encodeValue ) {
            $value = $this->encode($value);
        }
        
        $this->storage[ $header ] = $value;
        return $this;
    }
    
    public function add($header, $value, $encodeValue = false) 
    {
        if ( $encodeValue ) {
            $value = $this->encode($value);
        }
        
        if ( !isset($this->storage[ $header ]) ) {
            $this->storage[ $header ] = $value;
        }
        elseif ( is_array($this->storage[ $header ]) ) {
            $this->storage[ $header ][] = $value;
        }
        else {
            $this->storage[ $header ] = [ $this->storage[$header] ];
            $this->storage[ $header ][] = $value;
        }
        
        return $this;
    }
    
    public function has($header)
    {
        return isset($this->storage[ $header ]);
    }
    
    public function remove($header)
    {
        unset($this->storage[$header]);
        return $this;
    }
    
    public function getFirstOrArray($header)
    {
        if ( !$this->has($header) ) {
            return null;
        }
        
        return $this->storage[$header];
    }
    
    public function getFirst($header)
    {
        if ( !$this->has($header) ) {
            return null;
        }
        
        if ( is_array($this->storage[ $header ]) ) {
            return current($this->storage[ $header ]);
        }
        
        return $this->storage[ $header ];
    }
    
    public function getArray($header)
    {
        if ( !$this->has($header) ) {
            return [];
        }
        
        if ( is_array($this->storage[ $header ]) ) {
            return $this->storage[ $header ];
        }
        
        return [ $this->storage[ $header ] ];
    }
    
    
    public function __toString()
    {
        $result = '';
        
        foreach ( $this->storage as $header => $value ) {
            if ( is_array($value) ) {
                foreach ( $value as $subValue ) {
                    $result .= "$header: $subValue\r\n";
                }
            }
            else {
                $result .= "$header: $value\r\n";
            }
        }
        
        return $result;
    }
    
    public function encodeNonAscii($str)
    {
        return preg_replace_callback('/[[:^ascii:]].*[[:^ascii:]]+/u', function ($str) {
            return mb_encode_mimeheader($str[0]);
        }, $str);
    }
    
    public function encode($str)
    {
        return mb_encode_mimeheader($str);
    }
}