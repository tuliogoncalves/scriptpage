<?php

namespace App\Traits;

trait traitUserRole
{

    public function hasRole($name)
    {
        $roleName = explode('.', $name);
        $roleName[1] = $roleName[1] ?? '';

        $role = $this->roles()
            ->whereIn('name', [$roleName[0], $name])
            ->first();

        return isset($role);
    }

}
