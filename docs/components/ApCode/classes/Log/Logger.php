<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Log;

class Logger implements LoggerInterface
{
    private $prefix = 'site_';
    private $suffix = '.log';
    private $folder;
    
    private $format;
    
    public function __construct($folder)
    {
        $this->format = new Format();
        $this->folder = $folder;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Log\LoggerInterface::format()
     */
    public function format()
    {
        return $this->format;
    }
    
    private function logPath($log)
    {
        return "{$this->folder}/{$this->prefix}{$log}{$this->suffix}";
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Log\LoggerInterface::log()
     */
    public function log($log, $message)
    {
        $params = [];
        
        if ($message) {
            $params['message'] = $message;
        }
        
        file_put_contents($this->logPath($log), $this->format->format($params), FILE_APPEND);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Log\LoggerInterface::error()
     */
    public function error($message = NULL)
    {
        $this->log('errors', $message);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Log\LoggerInterface::info()
     */
    public function info($message = NULL)
    {
        $this->log('common', $message);
    }



}