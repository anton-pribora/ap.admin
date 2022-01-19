<?php

namespace Auth;

class Session extends \ApCode\Session\Session
{
    public function setIdentity(Identity $identity)
    {
        $this->set('identity', $identity);
    }

    public function hasIdentity()
    {
        return $this->has('identity');
    }

    /**
     * @return Identity
     */
    public function getIdentity()
    {
        return $this->get('identity');
    }
}
