<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Transport;

use ApCode\Mail\TransportInterface;
use ApCode\Mail\Message;
use ApCode\Misc\Options;
use Exception;

class Smtp implements TransportInterface
{
    private $login    = null;
    private $password = null;
    private $host     = null;
    private $port     = 25;
    private $smtpAuth = true;
    private $timeout  = 10;
    private $useSSL   = false;
    
    private $lastError     = null;
    private $lastErrorCode = null;
    
    private $socket = null;
    
    public function __construct(array $options = null)
    {
        if ( $options ) {
            $opt  = function($name, $default = null) use ($options) { return isset($options[$name]) ? $options[$name] : $default; };
            $bool = function($name, $default = false) use ($opt) { return in_array((string) $opt($name, $default), ['true', '1']); };
            
            $this->login    = $opt('login'   , $this->login);
            $this->password = $opt('password', $this->password);
            $this->host     = $opt('host'    , $this->host);
            $this->port     = $opt('port'    , $this->port);
            $this->timeout  = $opt('timeout' , $this->timeout);
            
            $this->useSSL   = $bool('ssl' , $this->useSSL);
            $this->smtpAuth = $bool('auth', strlen($this->login) > 0);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function name()
    {
        return __CLASS__;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Message $message)
    {
        $this->lastError = null;
        
        try {
            $this->openSocket();
            
            if ($this->smtpAuth) {
                $this->smtpSend(250, 'EHLO [192.168.0.1]', 'Connection to the server with authorization');
                $this->smtpSend(334, 'AUTH LOGIN', 'Authorization');
                $this->smtpSend(334, base64_encode($this->login), 'Authorization');
                $this->smtpSend(235, base64_encode($this->password), 'Authorization');
            }
            else {
                $this->smtpSend(250, 'HELO [192.168.0.1]', 'Connection to the server without authorization');
            }
            
            $this->smtpSend(250, "MAIL FROM:<{$message->getSenderEmail()}>", 'Define sender');
            
            foreach ($message->getRecipientsEmailOnly() as $recipient) {
                $this->smtpSend(250, "RCPT TO:<{$recipient}>", 'Define recipient');
            }
            
            $this->smtpSend(354, 'DATA', 'Sending message');
            $this->smtpSend(250, $message . "\r\n.", 'Sending message');
            $this->smtpSend(221, 'QUIT', 'End');
            
            $this->closeSocket();
        }
        catch (Exception $e) {
            $this->closeSocket();
            
            $this->lastError     = $e->getCode() .': '. $e->getMessage();
            $this->lastErrorCode = $e->getCode();
            
            return false;
        }
        
        return true;
    }
    
    private function openSocket()
    {
        $host = '';
        
        if ($this->useSSL) {
            $host .= 'ssl://';
        }
        
        $host .= "{$this->host}:{$this->port}";
        
        $this->socket = @stream_socket_client($host, $errorNumber, $errorDescription, 2);
        
        if (!is_resource($this->socket)) {
            throw new Exception(sprintf('Could not connect to %s:%s. Error %s: %s.',
                (string) $this->host,
                (string) $this->port,
                (string) $errorNumber,
                (string) $errorDescription
            ), 100);
        }
        
        stream_set_timeout($this->socket, $this->timeout);
        
        $line = $this->socketRead();
        
        if (!preg_match('/^220\s/', $line)) {
            throw new Exception('The connection could not be established. The server returned an unexpected response: '. $line, 101);
        }
    }
    
    private function smtpSend($expectedCode, $command, $stage)
    {
        $this->socketWrite($command ."\r\n");
        
        while (!feof($this->socket)) {
            $line = trim($this->socketRead());
            
            if (preg_match('/^(\d{3})(?:\s+(.*))?$/', $line, $matches)) {
                list(, $code, $text) = $matches;
                
                if ($code != $expectedCode) {
                    throw new Exception(sprintf('At the stage of "%s" the code %s was expected, but the server returned %s',
                        $stage,
                        $expectedCode,
                        $line
                    ), 102);
                }
                
                return true;
            }
        }
        
        throw new Exception('The server unexpectedly closed the connection', 104);
    }
    
    private function closeSocket()
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
    }
    
    private function socketWrite($data)
    {
        if (!@fwrite($this->socket, $data)) {
            throw new Exception(sprintf('Could not write to the socket: %s. Error: %s',
                $data,
                $this->lastPhpErrorMessage('unknown socket error')
            ), 103);
        }
    }
    
    private function socketRead()
    {
        $data = @fgets($this->socket);
        
        if ($data === false) {
            throw new Exception(sprintf('Could not read data from the socket. Error: %s',
                $this->lastPhpErrorMessage('unknown socket error')
            ), 104);
        }
        
        return $data;
    }
    
    private function lastPhpErrorMessage($default = '')
    {
        $error = error_get_last();
        return isset($error['message']) ? $error['message'] : $default;
    }
}
