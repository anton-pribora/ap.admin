<?php 

namespace Data;

class Ini
{
    private $ini = null;
    private $iniArray = [];
    
    public function __construct($ini)
    {
        $this->ini = $ini;
        $this->parse();
    }
    
    public function __toString()
    {
        return $this->ini;
    }
    
    private function parse()
    {
        $this->iniArray = parse_ini_string($this->ini, true);
    }
    
    public function get($path, $default = NULL)
    {
        $key = strtr($path, ['.' => "']['"]);
        return eval("return \$this->iniArray['$key'] ?? \$default;"); 
    }
    
    public function setRawValue($path, $value)
    {
        $array = explode('.', $path, 2);
        
        if (count($array) != 2) {
            throw new \Exception("Please provide 'section.key' format not '$path'");
        }
        
        list($section, $key) = $array;
        
        $lines     = explode("\n", $this->ini);
        $result    = [];
        $inSection = false;
        $setted    = false;
        
        while ($lines) {
            $line = array_shift($lines);
            
            if (preg_match('~^\s*\[\s*(\w+)~', trim($line), $matches)) {
                if ($inSection && !$setted) {
                    $result[] = sprintf('%s = %s', $key, $value);
                    $setted = true;
                }
                
                $inSection = $section == $matches[1];
            } elseif (preg_match('~\s*([\w\.]+)\s*=\s*~', $line, $matches)) {
                if ($inSection && $matches[1] == $key) {
                    $line = $matches[0] . $value;
                    $setted = true;
                } 
            }
            
            $result[] = $line;
        }
        
        if ($inSection && !$setted) {
            $result[] = sprintf('%s = %s', $key, $value);
            $setted = true;
        }
        
        if (!$setted) {
            $result[] = "[$section]";
            $result[] = "$key = $value";
        }
        
        $this->ini = join("\n", $result);
        $this->parse();
        
        return $this;
    }
}