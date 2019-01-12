<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Filter;

use ApCode\Mail\Message;

abstract class AbstractFilter
{
    protected $pattern = null;
    
    public function __construct($pattern = null)
    {
        $this->pattern = $pattern;
    }
    
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }
    
    public function getPattern()
    {
        return $this->pattern;
    }
    
    protected function match($string)
    {
        return preg_match('~^'. $this->pattern .'$~', $string) > 0;
    }
    
    abstract public function isValid(Message $message);
    
    public function __invoke(Message $message)
    {
        return $this->isValid($message);
    }
}