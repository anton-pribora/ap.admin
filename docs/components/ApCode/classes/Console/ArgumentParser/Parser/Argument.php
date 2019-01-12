<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Console\ArgumentParser\Parser;

class Argument
{
    private $definition;
    
    private $container;
    private $multiple;
    
    private $shortOpts;
    private $longOpts;
    private $matchOpts;
    
    public function __construct($definition)
    {
        $this->definition = $definition;
        $this->parseDefinition();
    }
    
    private function parseDefinition()
    {
        $tokens = preg_split('~[ ,]+~', $this->definition, -1, PREG_SPLIT_NO_EMPTY);
        
        $this->shortOpts = [];
        $this->longOpts  = [];
        $this->matchOpts = [];
        
        foreach ($tokens as $token) {
            if (preg_match('~^--[\w-]+$~u', $token)) {
                $this->longOpts[$token] = ltrim($token, '-');
                continue;
            } elseif (preg_match('~^--[\w\*-]+$~u', $token)) {
                $this->matchOpts[$token] = ltrim($token, '-');
                continue;
            } elseif (preg_match('~^-\w$~u', $token)) {
                $this->shortOpts[] = ltrim($token, '-');
                continue;
            }
            
            switch ($token) {
                case '=':
                case 'container':
                    $this->container = true;
                    break;
                    
                case '+':
                case 'multiple':
                    $this->multiple = true;
                    break;
                    
                default:
                    throw new Exception(sprintf("Неверный токен `%s' для определения параметра парсера аргументов. Объявление: '%s'", $token, $this->definition));
                    break;
            }
        }
        
        if ($this->matchOpts && $this->isMultiple()) {
            throw new Exception(sprintf("Нельзя использовать '+' с шаблонными аргументами. Объявление: '%s'", $this->definition));
        }
    }
    
    
    public function shortOpts()
    {
        return $this->shortOpts;
    }
    
    public function longOpts()
    {
        return $this->longOpts;
    }
    
    public function matchOpts()
    {
        return $this->matchOpts;
    }
    
    public function isContainer()
    {
        return (bool) $this->container;
    }
    
    public function isMultiple()
    {
        return (bool) $this->multiple;
    }
}