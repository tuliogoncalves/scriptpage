<?php

namespace App\Services\Cruds;

use App\Models\Role;
use App\Models\User;
use App\Scriptpage\Repository\Crud;

class UserCrud extends Crud
{
    protected string $modelClass = User::class;

    function setDataValidation(): array
    {
        return [
            'name' => 'required|max:25',
            'email' => 'required|email',
        ];
    }

    function setDataPayload(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email']
        ];
    }

    function updateRoles($user)
    {
        $data = $this->data;

        foreach ($user->roles as $role) {
            if (array_search($role->name, $data['roles']) === false) {
                $role->delete();
            }
        }

        foreach ($data['roles'] as $role) {
            Role::updateOrCreate([
                'user_id' => $user->id,
                'name' => $role
            ]);
        }
    }

    function store()
    {
        $user = parent::store();
        $this->updateRoles($user);
        return $user;
    }

    function update($id)
    {
        $user = parent::update($id);
        $this->updateRoles($user);
        return $user;
    }
}
