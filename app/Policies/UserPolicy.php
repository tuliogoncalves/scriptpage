<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function approve(User $user, String $role)
    {
        return $user->hasRole($role)
            ? Response::allow()
            : Response::deny('You do not view this data.');
    }
}
