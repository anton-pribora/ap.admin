<?php

namespace Project;

trait RoleAdmin
{
    function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
