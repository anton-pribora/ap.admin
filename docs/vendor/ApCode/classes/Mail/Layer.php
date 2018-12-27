<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail;

use ApCode\Misc\Triggers;

/**
 * Организует отправку почты через несколько транспортов.
 * 
 * @example
 * Пример использования:
 * 
 * $layer     = new Layer();
 * $transport = new Transport\PhpMail;
 * 
 * $layer->appendTransport($transport);
 * 
 * // Обратный адрес по умолчанию
 * $layer->appendTrigger('beforeSend', function(Message $message){
 *     if ( !$message->getSenderEmail() ) {
 *         $message->setSenderEmail('default@email');
 *     }
 * });
 *
 * // Логирование ошибок
 * $layer->appendTrigger('error', function(Message $message, TransportInterface $transport){
 *     log('Cообщение %s для %s не было доставлено. Ошибка: %s',
 *         $message->getId(),
 *         $message->getRecipients(', '),
 *         $transport->getLastError()
 *     );
 * });
 *
 * // Логирование отправленных сообщений
 * $layer->appendTrigger('afterSend', function(Message $message){
 *     log('Отправлено сообщение %s для %s от %s.',
 *         $message->getId(),
 *         $message->getRecipients(', '),
 *         $message->senderEmail()
 *     );
 * });
 * 
 * $message = new Message;
 * $messate->addRecipient('foo@bar');
 * $message->setContent('Привет, мир!');
 * 
 * if ( !$layer->send($message) ) {
 *     var_dump($layer->getErrors());
 * }
 * 
 * @author Anton Pribora <info@anton-pribora.ru>
 * @package rake-engine
 */
class Layer
{
    use Triggers;
    
    private $transports = [];
    private $errors     = [];
    
    public function appendTranspport(TransportInterface $transport, callable $filter = null)
    {
        $this->transports[] = [$transport, $filter];
        return $this;
    }
    
    public function send(Message $message)
    {
        $this->errors = [];
        
        $this->launchTriggers('beforeSend', $message, $this);
        
        foreach ( $this->transports as list($transport, $filter) ) {
            if ( $filter ) {
                if ( !$filter($message) ) {
                    continue;
                }
            }
            
            if ( !$transport->send($message) ) {
                $this->launchTriggers('error', $message, $transport, $this);
                $this->errors[] = $transport->getLastError();
            }
        }
        
        $this->launchTriggers('afterSend', $message, $this);
        
        return empty($this->errors);
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}