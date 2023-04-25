<?php

namespace App\Http\Controllers;

use App\Cruds\FornecedorCrud;

use App\Repositories\FornecedoresRepository;
use App\Scriptpage\Controllers\CrudController;

class FornecedoresController extends CrudController
{
    protected $repositoryClass = FornecedoresRepository::class;
    protected $crudClass = FornecedorCrud::class;

    protected $template = "Fornecedores";

    protected function dataEdit($id = null, $id2 = null)
    {
        return [
            'data' => $this->repository->with('roles')->find($id)
        ];
    }
}
