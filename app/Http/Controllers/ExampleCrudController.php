<?php

namespace App\Http\Controllers;

use App\Cruds\UserCrud;

use App\Repositories\UserRepository;
use App\Scriptpage\Controllers\CrudController;

class ExampleBaseController extends CrudController
{
    protected $repositoryClass = UserRepository::class;
    protected $crudClass = UserCrud::class;
    // protected $serviceClass = UserService::class;

    protected $template = "Users";


    // /**
    //  * Custom init
    //  *
    //  * @return void
    //  */
    // protected function init()
    // {
    // }
    
    
    // protected function dataIndex($id = null, $id2 = null)
    // {
    //     return [
    //         'paginator' => $this->repository->getData()
    //     ];
    // }


    // protected function dataCreate($id = null, $id2 = null)
    // {
    //     return [
    //         'data' => $this->crud->create()
    //     ];
    // }


    // protected function dataShow($id = null, $id2 = null)
    // {
    //     return $this->dataIndex($id, $id2);
    // }

    
    // protected function dataEdit($id = null, $id2 = null)
    // {
    //     return [
    //         'data' => $this->repository->find($id)
    //     ];
    // }
}
