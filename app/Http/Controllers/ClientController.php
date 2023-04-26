<?php

namespace App\Http\Controllers;

use App\Cruds\ClientCrud;

use App\Repositories\ClientRepository;
use App\Scriptpage\Controllers\CrudController;

class ClientController extends CrudController
{
    protected $repositoryClass = ClientRepository::class;
    protected $crudClass = ClientCrud::class;

    protected $template = "Clients";

    protected function dataEdit($id = null, $id2 = null)
    {
        return [
            'data' => $this->repository->find($id)
        ];
    }
}
