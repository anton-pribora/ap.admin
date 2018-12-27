<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Transport;

use ApCode\Mail\TransportInterface;
use ApCode\Mail\Message;

class PhpMail implements TransportInterface
{
    private $lastError = null;
    
    public function __construct(array $options = null)
    {
        if ( $options ) {
        }
    }
    
    public function send(Message $message)
    {
        $recipients = $message->getRecipients(', ');
        $subject    = $message->getSubject();
        
        list($headers, $body) = explode("\r\n\r\n" , (string) $message, 2);
        
        $result = @mail($recipients, $subject, $body, $headers);
        
        if ( !$result ) {
            $error = error_get_last();
            
            if ( $error ) {
                $this->lastError = 'PhpMail:'. $error['message'];
            }
            else {
                $this->lastError = 'PhpMail: Неизвестная ошибка';
            }
        }
        
        return $result;
    }
    
    public function getLastError()
    {
        return $this->lastError;
    }
}