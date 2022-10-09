<?php

namespace App\Services\Roles;

use App\Scriptpage\Repository\BaseService;

class RoleService extends BaseService
{
    static function listOfRoles() {
        return Array(
            self::addListRole('admin', 'Adminstrador'),
            self::addListRole('info', 'PHP-Info'),
            self::addListRole('getdata', 'Repositories getData()')
        );
    }

    private static function addListRole($id, $name): array {
        return [
            'id' => $id,
            'name' => $name
        ];
    }
}