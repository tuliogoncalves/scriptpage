<?php

namespace App\Services;

class RoleService
{
    static function listOfRoles()
    {
        return array_merge(
            self::addPermissions('admin', 'Administrator'),
            self::addPermissions('users', 'Users'),
            [
                self::addListRole('info', 'PHP-Info'),
                self::addListRole('getdata', 'Repositories getData()')
            ]
        );
    }

    private static function addListRole($id, $name): array
    {
        return [
            'id' => $id,
            'name' => $name
        ];
    }

    private static function addPermissions($id, $name)
    {
        return [
            self::addListRole($id, $name),
            self::addListRole("$id.index", "$name(index)"),
            self::addListRole("$id.show", "$name(show)"),
            self::addListRole("$id.edit", "$name(edit)"),
            self::addListRole("$id.store", "$name(store)"),
            self::addListRole("$id.update", "$name(update)"),
            self::addListRole("$id.delete", "$name(delete)"),
        ];
    }
}
