<?php

namespace App\Http\Controllers;

use App\Cruds\UserCrud;

use App\Repositories\FornecedoresRepository;
use App\Scriptpage\Controllers\CrudController;

class FornecedoresController extends CrudController
{
    protected $repositoryClass = UserRepository::class;
    protected $crudClass = UserCrud::class;

    protected $template = "Users";

    protected function dataEdit($id = null, $id2 = null)
    {
        return [
            'data' => $this->repository->with('roles')->find($id)
        ];
    }
}
