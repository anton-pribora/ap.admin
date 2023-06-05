<?php

namespace Project;

trait Roles
{
    public function rolesRaw()
    {
        return $this->meta('roles', []);
    }

    public function setRolesRaw($value)
    {
        $this->setMeta('roles', (array) $value);
        return $this;
    }

    /**
     * @return Role[]
     */
    public function roles()
    {
        $result = [];

        foreach ($this->rolesRaw() as $tag) {
            $result[] = RoleRepository::findOne(['tag' => $tag]);
        }

        return array_filter($result);
    }

    public function hasRole($role)
    {
        return in_array($role, $this->rolesRaw());
    }

    public function addRole($role)
    {
        if (!$this->hasRole($role)) {
            $this->setRolesRaw([...$this->rolesRaw(), $role]);
        }

        return $this;
    }
}
