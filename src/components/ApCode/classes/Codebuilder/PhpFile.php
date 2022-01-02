<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpFile
{
    protected $contents = [];
    
    public function __construct()
    {
        $this->addContents('<?php'. PHP_EOL);
    }
    
    public function addContents($contents)
    {
        $this->contents[] = (string) $contents;
        
        return $this;
    }
    
    public function addContentLine($line)
    {
        $this->contents[] = (string) $line;
        $this->contents[] = PHP_EOL;
        
        return $this;
    }
    
    public function __toString()
    {
        return join($this->contents);
    }
}