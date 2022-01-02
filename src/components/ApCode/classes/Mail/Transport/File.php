<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Transport;

use ApCode\Mail\TransportInterface;
use ApCode\Mail\Message;

class File implements TransportInterface
{
    private $saveDir      = null;
    private $createDir    = TRUE;
    private $lastMailPath = null;
    private $lastError    = null;
    
    public function __construct(array $options = null)
    {
        if ( $options ) {
            $this->saveDir = isset($options['dir']) ? rtrim($options['dir'], '/') : null;
        }
    }
    
    public function setSaveDir($path)
    {
        $this->saveDir = $path;
        return $this;
    }
    
    public function getSaveDir()
    {
        return $this->saveDir;
    }
    
    public function getLastMailPath()
    {
        return $this->lastMailPath;
    }
    
    public function send(Message $mesage)
    {
        $filename = $this->saveDir .'/'. uniqid(date('Y-m-d_H:i:s_')) .'.eml';
        $this->lastMailPath = $filename;
        
        if ($this->saveDir && !file_exists($this->saveDir) && $this->createDir) {
            if (!mkdir($this->saveDir, 0755, true)) {
                $this->lastError = 'Can\'t create dir '. $this->saveDir;
                return false;
            }
        }
        
        $result = file_put_contents($filename, (string) $mesage);
        
        if ( $result === false ) {
            $this->lastError = error_get_last()['message'];
        }
        
        return $result !== false;
    }
    
    public function getLastError()
    {
        return $this->lastError;
    }
}