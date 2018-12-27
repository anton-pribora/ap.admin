<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\File;

class File
{
    private $path = null;
    
    public function __construct($path)
    {
        $this->path = $path;
        $this->initialize();
    }
    
    protected function initialize()
    {
    }
    
    public function path()
    {
        return $this->path;
    }
}