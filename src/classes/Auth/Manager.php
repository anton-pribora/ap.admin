<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Auth;

use ApCode\Session\Container;

class Manager
{
    private $storage;
    
    public function __construct(Container $storage)
    {
        $this->storage = $storage;
    }
    
    public function activeSession()
    {
        return new Session('active', $this->storage);
    }
}