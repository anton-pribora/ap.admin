<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Auth;

class Credentials
{
    private $login;
    private $password;
    
    public function __construct($login, $password)
    {
        $this->login    = $login;
        $this->password = $password;
    }
    
    public function login()
    {
        return $this->login;
    }

    public function password()
    {
        return $this->password;
    }
}