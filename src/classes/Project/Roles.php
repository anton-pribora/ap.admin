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
        return $this->rolesRaw() ? RoleRepository::findMany(['tag' => $this->rolesRaw()]) : [];
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
