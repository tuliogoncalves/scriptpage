<?php

namespace App\Http\Controllers;

use App\Scriptpage\Controllers\CrudController;
use App\Services\Cruds\UserCrud;
use App\Services\Repositories\UserRepository;
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

    
    function dataCreate(Request $request, $id = null, $id2 = null): array
    {
        return [
            'data' => $this->crud->with('roles')->create()
        ];
    }
}
