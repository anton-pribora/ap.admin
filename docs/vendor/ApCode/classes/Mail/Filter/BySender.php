<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Filter;

use ApCode\Mail\Message;

class BySender extends AbstractFilter
{
    public function isValid(Message $message)
    {
        return $this->match($message->getSenderEmail());
    }
}