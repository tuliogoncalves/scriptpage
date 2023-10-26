<?php

namespace App\Traits;

trait traitUserJWT
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
