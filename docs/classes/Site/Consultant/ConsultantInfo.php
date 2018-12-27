<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site\Consultant;

use Data\BasicData;
use Site\Consultant;

class ConsultantInfo extends BasicData
{
    public function login()
    {
        return $this->data['login'] ?? '';
    }
    
    public function setLogin($value)
    {
        $this->data['login'] = $value;
        return $this;
    }
    
    public function password()
    {
        return $this->data['password'] ?? '';
    }
    
    public function setPassword($value)
    {
        $this->data['password'] = $value;
        return $this;
    }
    
    public function firstName()
    {
        return $this->data['firstName'];
    }
    
    public function setFirstName($value)
    {
        $this->data['firstName'] = $value;
        return $this;
    }
    
    public function lastName()
    {
        return $this->data['lastName'] ?? '';
    }

    public function setLastName($value)
    {
        $this->data['lastName'] = $value;
        return $this;
    }

    public function post()
    {
        return $this->data['post'] ?? '';
    }

    public function setPost($value)
    {
        $this->data['post'] = $value;
        return $this;
    }

    public function email()
    {
        return $this->data['email'] ?? '';
    }

    public function setEmail($value)
    {
        $this->data['email'] = $value;
        return $this;
    }

    public function phone()
    {
        return $this->data['phone'] ?? '';
    }

    public function setPhone($value)
    {
        $this->data['phone'] = $value;
        return $this;
    }
    
    public function skype()
    {
        return $this->data['skype'] ?? '';
    }

    public function setSkype($value)
    {
        $this->data['skype'] = $value;
        return $this;
    }

    public function roleId()
    {
        return $this->data['roleId'] ?? '';
    }

    public function setRoleId($value)
    {
        $this->data['roleId'] = $value;
        return $this;
    }
    
    public function roleName()
    {
        return Consultant::roles()[$this->roleId()] ?? '';
    }
}
