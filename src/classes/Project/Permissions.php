<?php

namespace Project;

trait Permissions
{
    private $permissions = null;

    public function permissionValueByFile($path, $default = false)
    {
        $permission = __path_to_permission($path);

        if (!isset($this->permissions)) {
            $this->permissions = [];

            foreach ($this->roles() as $role) {
                $this->permissions = array_merge($this->permissions, $role->permissions());
            }
        }

        return $this->permissions[$permission] ?? $default;
    }

    public function permissions()
    {
        return $this->permissions;
    }
}
