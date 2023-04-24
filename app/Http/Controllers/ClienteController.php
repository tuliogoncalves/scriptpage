<?php

namespace App\Http\Controllers;

use App\Cruds\ClienteCrud;

use App\Repositories\ClienteRepository;
use App\Scriptpage\Controllers\CrudController;

class ClienteController extends CrudController
{
    protected $repositoryClass = ClienteRepository::class;
    protected $crudClass = ClienteCrud::class;

    protected $template = "Clientes";

    protected function dataEdit($id = null, $id2 = null)
    {
        $teste = $this->repository->find($id);
        dd($teste);
        return [
            'data' => $teste
        ];
    }
}
