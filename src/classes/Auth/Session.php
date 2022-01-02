<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Auth;

use ApCode\Session\Container;

class Session
{
    private $id;
    private $storage;
    
    public function __construct($id, Container $container)
    {
        $this->id      = $id;
        $this->storage = $container;
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function setIdentity(Identity $identity)
    {
        $this->storage['identity'] = $identity;
    }
    
    /**
     * @return \Auth\Identity
     */
    public function identity()
    {
        return $this->storage['identity'];
    }
}