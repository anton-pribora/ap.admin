<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

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
