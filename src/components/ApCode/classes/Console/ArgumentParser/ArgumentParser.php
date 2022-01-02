<?php

namespace ApCode\Console\ArgumentParser;

/**
 * Класс для обработки параметров командной строки
 * 
 * @example
 *      Пример конфига
 *      $config = [
 *          'user'    => '-u, --user, =',
 *          'verbose' => '-v, +',
 *      ];
 *      
 *      Опции, начинающиеся с однарного -, считаются короткими параметрами (могут быть только односимвольными).
 *      Опции, начинающиеся с двойного --, считаются длинными параметрами (значение указывается через =).
 *      
 *      Знак '=' означает, что опция может иметь значение.
 *      Знак '+' означает, что опция может быть объявлена несколько раз.
 *      
 *      Пример вызова
 *      ./app.php -u root -vvv
 *      ./app.php -uroot -v -v -v
 *      ./app.php --user=root
 * 
 * @author Anton Pribora (https://anton-pribora.ru)
 * @license MIT
 */
class ArgumentParser
{
    private $config;
    
    /**
     * @var \ApCode\Console\ArgumentParser\Parser\Argument
     */
    private $items;
    
    private $result;
    
    private $shortOpts;
    private $longOpts;
    private $matchOpts;
    
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }
    
    public function setConfig(array $config)
    {
        $this->config = $config;
        $this->parseConfig();
    }
    
    private function parseConfig()
    {
        $this->items     = [];
        $this->shortOpts = [];
        $this->longOpts  = [];
        $this->matchOpts = [];
        
        foreach ($this->config as $id => $config) {
            $item = new Parser\Argument($config);
            $this->items[$id] = $item;
            
            foreach ($item->shortOpts() as $opt) {
                if (isset($this->shortOpts[$opt])) {
                    throw new Parser\Exception("Дублирующийся параметр `-%s'", $opt);
                }
                
                $this->shortOpts[$opt] = $id;
            }
            
            foreach ($item->longOpts() as $opt) {
                if (isset($this->longOpts[$opt])) {
                    throw new Parser\Exception("Дублирующийся параметр `--%s'", $opt);
                }
                
                $this->longOpts[$opt] = $id;
            }
            
            foreach ($item->matchOpts() as $opt) {
                if (isset($this->matchOpts[$opt])) {
                    throw new Parser\Exception("Дублирующийся параметр `--%s'", $opt);
                }
                
                $this->matchOpts[$opt] = $id;
            }
        }
    }
    
    /**
     * @param array $arguments
     * @return \ApCode\Console\ArgumentParser\Parser\Result
     */
    public function parse(array $arguments)
    {
        /**
         * Внимание! Возрастное ограничение 18+
         * Просмотр и понимание данной функции может негативно сказаться на вашей психике!
         *                                                                 Я предупредиль.
         */
        
        $this->result = new Parser\Result();
        
        while ($arguments) {
            $arg = array_shift($arguments);
            
            if ($arg == '--') {
                foreach ($arguments as $arg) {
                    $this->result->addArgument($arg);
                }
                
                break;
            }
            elseif (preg_match('~^--([\w-]+)(=([\s\S]*))?$~u', $arg, $matches)) {
                $key   = $matches[1];
                $value = $matches[3] ?? null;
                
                if (isset($this->longOpts[$key])) {
                    $id    = $this->longOpts[$key];
                    $item  = $this->items[$id];
                    
                    if ($item->isMultiple()) {
                        $this->result->addOpt($id, $value);
                    } else {
                        $this->result->setOpt($id, $value);
                    }
                } else {
                    foreach ($this->matchOpts as $pattern => $id) {
                        if (fnmatch($pattern, $key)) {
                            $this->result->addOpt($id, $value, $key);
                            continue 2;
                        }
                    }
                    
                    $this->result->addUnknown("--$key", $value);
                }
            } elseif (preg_match('~^-\w~u', $arg)) {
                $arg = mb_substr($arg, 1);
                
                do {
                    $char = mb_substr($arg, 0, 1);
                    $arg  = mb_substr($arg, 1);
                    
                    if (isset($this->shortOpts[$char])) {
                        $id   = $this->shortOpts[$char];
                        $item = $this->items[$id];
                        
                        if ($item->isContainer()) {
                            if (mb_strlen($arg)) {
                                $value = $arg;
                                $arg   = '';
                            } else {
                                if ($arguments) {
                                    $value = array_shift($arguments);
                                } else {
                                    $value = null;
                                }
                            }
                        } else {
                            $value = true;
                        }
                            
                        if ($item->isMultiple()) {
                            $this->result->addOpt($id, $value);
                        } else {
                            $this->result->setOpt($id, $value);
                        }
                    } else {
                        $this->result->addUnknown("-$char", null);
                    }
                } while (mb_strlen($arg));
            } else {
                $this->result->addArgument($arg);
            }
        }
        
        return $this->result;
    }
    
    /**
     * @return \ApCode\Console\ArgumentParser\Parser\Result
     */
    public function result()
    {
        return $this->result;
    }
}