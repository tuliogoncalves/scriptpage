<?php

namespace App\Scriptpage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CrudController extends BaseController
{
    use traitCrud;

    public function index(Request $request, $id = null, $id2 = null)
    {
        $this->makeRepository($request->all());
        $this->setSessionUrl($request);
        return $this->sendResponse(
            $this->template . '/index',
            $this->dataIndex($id, $id2)
        );
    }


    public function create(Request $request, $id = null, $id2 = null)
    {
        $this->makeCrud();
        return $this->sendResponse(
            $this->template . '/form',
            $this->dataCreate($id, $id2)
        );
    }


    public function show(Request $request, $id = null, $id2 = null)
    {
        $this->makeRepository($request->all());
        return $this->sendResponse(
            $this->template . '/form',
            $this->dataShow($id, $id2)
        );
    }


    public function edit(Request $request, $id, $id2 = null)
    {
        $this->makeRepository($request->all());
        return $this->sendResponse(
            $this->template . '/form',
            $this->dataEdit($id, $id2)
        );
    }


    public function store(Request $request, $id = null, $id2 = null)
    {
        $this->makeCrudStore();
        $this->crudStore($request, $id, $id2);
        return Redirect::to($this->getSessionUrl());
    }


    public function update(Request $request, $id = null, $id2 = null)
    {
        $this->makeCrudUpdate();
        self::crudUpdate($request, $id, $id2);
        return Redirect::to($this->getSessionUrl());
    }


    public function destroy(Request $request, $id = null, $id2 = null)
    {
        $this->makeCrudDelete();
        self::crudDestroy($request, $id, $id2);
        return Redirect::to($this->getSessionUrl());
    }


    protected function dataIndex($id = null, $id2 = null)
    {
        return [
            'paginator' => $this->repository->getData()
        ];
    }


    protected function dataCreate($id = null, $id2 = null)
    {
        return [
            'data' => $this->crud->create()
        ];
    }


    protected function dataShow($id = null, $id2 = null)
    {
        return $this->dataEdit($id, $id2);
    }

    
    protected function dataEdit($id = null, $id2 = null)
    {
        return [
            'data' => $this->repository->find($id)
        ];
    }
}
