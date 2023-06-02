<?php

namespace Project;

/**
 * (Без названия)
 */
class ProfileCredential extends \ApCode\Billet\AbstractBillet
{
    public function id()
    {
        return $this->data['id'] ?? null;
    }

    public function setId($value)
    {
        $this->data['id'] = $value;
        return $this;
    }

    public function profileId()
    {
        return $this->data['profileId'] ?? null;
    }

    public function setProfileId($value)
    {
        $this->data['profileId'] = $value;
        return $this;
    }

    public function profile()
    {
        return Profile::getInstance($this->profileId());
    }

    public function login()
    {
        return $this->data['login'] ?? null;
    }

    public function setLogin($value)
    {
        $this->data['login'] = $value;
        return $this;
    }

    public function password()
    {
        return $this->data['password'] ?? null;
    }

    public function setPassword($value)
    {
        $this->data['password'] = password_hash($value, null);
        return $this;
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password());
    }

    public function createdAt()
    {
        return $this->data['createdAt'] ?? null;
    }

    public function setCreatedAt($value)
    {
        $this->data['createdAt'] = $value;
        return $this;
    }

    public function lastLoginTime()
    {
        return $this->data['lastLoginTime'] ?? null;
    }

    public function setLastLoginTime($value)
    {
        $this->data['lastLoginTime'] = $value;
        return $this;
    }

    public function del()
    {
        return $this->data['del'] ?? null;
    }

    public function setDel($value)
    {
        $this->data['del'] = $value;
        return $this;
    }
}
