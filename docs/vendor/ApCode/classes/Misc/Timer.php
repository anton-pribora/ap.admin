<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Misc;

class Timer
{
    private $start;
    private $end;
    
    private $format = '%.3fsec';
    
    public function start()
    {
        $this->start = microtime(true);
        $this->end   = null;
        
        return $this;
    }
    
    public function stop()
    {
        $this->end = microtime(true);
        
        return $this;
    }
    
    public function elapsed()
    {
        if (empty($this->end)) {
            return microtime(true) - $this->start;
        } else {
            return $this->end - $this->start;
        }
    }
    
    public function __toString()
    {
        return sprintf($this->format, $this->elapsed());
    }
}