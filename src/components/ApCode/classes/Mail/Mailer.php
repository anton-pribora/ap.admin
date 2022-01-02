<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail;

use ApCode\Mail\Message;
use ApCode\Mail\Layer;

class Mailer
{
    private $version = '1.0.2';
    
    private $layer;
    
    public function __construct()
    {
        $this->layer = new Layer();
    }
    
    /**
     * @example 
     * $config = [
     *     'defaultFrom' => 'mymail@example.org',
     * //  'onError'     => function($error, $message, $transport) { myErrorLog($error); },
     * //  'afterSend'   => function($text, $message, $layer) { myMailLog($text); },
     *     'transports'  => [
     *         ['file', 'dir'  => __DIR__ .'/mails'],
     * //      ['smtp', 'host' => 'smtp.yandex.ru', 'ssl' => true, 'port' => '465', 'login' => '****@yandex.ru', 'password' => '******'],
     * //      ['smtp', 'host' => 'smtp.gmail.com', 'ssl' => true, 'port' => '465', 'login' => '****@gmail.com', 'password' => '******'],
     * //      ['smtp', 'host' => '192.168.0.1', 'timeout' => 30],
     *     ],
     * ];
     * @param array $config
     */
    public function init(array $config = [])
    {
        $conf  = function($name, $default = null) use (&$config) { return isset($config[$name]) ? $config[$name] : $default;};
        $layer = new Layer();
        
        $defaultFrom = $conf('defaultFrom');
        $onError     = $conf('onError');
        $afterSend   = $conf('afterSend');
        $transports  = $conf('transports', []);
        
        // Обратный адрес по умолчанию
        if ($defaultFrom) {
            $layer->appendTrigger('beforeSend', function(Message $message) use ($defaultFrom){
                if (!$message->getSenderEmail()) {
                    $message->setSenderEmail($defaultFrom);
                }
            });
        }
        
        if ($onError) {
            $layer->appendTrigger('error', function(Message $message, TransportInterface $transport) use ($onError){
                $error = sprintf('Message %s for %s was not delivered via %s. Error: %s',
                    $message->getId(),
                    $message->getRecipients(', '),
                    $transport->name(),
                    $transport->getLastError()
                );
                
                call_user_func($onError, $error, $message, $transport);
            });
        }
        
        if ($afterSend) {
            $layer->appendTrigger('afterSend', function(Message $message, Layer $layer) use ($afterSend) {
                $text = sprintf('Message %s was sent to %s from %s.%s',
                    $message->getId(),
                    $message->getRecipients(', '),
                    $message->getSenderEmail(),
                    $layer->getErrors() ? ' Errors: ' . join(', ', $layer->getErrors()) : ''
                );
                
                call_user_func($afterSend, $text, $message, $layer);
            });
        }
        
        foreach ($transports as $options) {
            $options = (array) $options;
            $type    = array_shift($options);
            
            $layer->appendTranspport(
                $this->newTransport($type, $options)
            );
        }
        
        $this->layer = $layer;
    }
    
    /**
     * @return \ApCode\Mail\Layer
     */
    public function layer()
    {
        return $this->layer;
    }
    
    public function newTransport($type, $config = [])
    {
        $class = __NAMESPACE__ .'\\Transport\\'. ucfirst(strtolower($type));
        return new $class($config);
    }
    
    public function addTransport(TransportInterface $transport)
    {
        $this->layer->appendTranspport($transport);
        return $this;
    }
    
    public function newHtmlMessage()
    {
        return new Message();
    }
    
    public function newTextMessage()
    {
        return $this->newHtmlMessage()->setContentTypeTextPlain();
    }
    
    public function sendMessage(Message $message)
    {
        return $this->layer->send($message);
    }
    
    public function lastErrors()
    {
        return $this->layer->getErrors();
    }
    
    public function version()
    {
        return $this->version;
    }
}
