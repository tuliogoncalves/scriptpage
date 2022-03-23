<?php

namespace App\Http\Controllers;

use App\Cruds\UserCrud;
use App\Repositories\UserRepository;
use App\Scriptpage\Controllers\CrudController;
use Illuminate\Http\Request;

class UserController extends CrudController
{
    protected $repositoryClass = UserRepository::class;
    protected $crudClass = UserCrud::class;

    protected $template = "Users";

    function dataEdit(Request $request, $id, $id2 = null): array
    {
        return [
            'data' => $this->repository->with('roles')->find($id)
        ];
    }
}
