<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CrudController extends BaseController
{

    public function index(Request $request, $id = null, $id2 = null)
    {
        $this->setSessionUrl($request);
        return $this->sendResponse(
            $this->template . '/index',
            [
                'paginator' => $this->repository->getData()
            ]
        );
    }


    public function create(Request $request, $id = null, $id2 = null)
    {
        return $this->sendResponse(
            $this->template . '/form',
            [
                'data' => $this->crud->create()
            ]
        );
    }


    public function show(Request $request, $id = null, $id2 = null)
    {
        return $this->sendResponse(
            $this->template . '/form',
            [
                'data' => $this->repository->find($id)
            ]
        );
    }


    public function edit(Request $request, $id, $id2 = null)
    {
        return $this->sendResponse(
            $this->template . '/form',
            [
                'data' => $this->repository->find($id)
            ]
        );
    }


    public function store(Request $request, $id = null, $id2 = null)
    {
        // Set request data
        $this->crud->setData($request->all());

        // Valida data
        $validator = $this->crud->validate();
        $validator->validate();

        // Try storage new data
        $this->crud->store();

        // Success flash message
        Session::flash('success', 'Registro Adicionado com Sucesso');

        // Get ID from model
        if (is_null($id)) {
            $id = $this->crud->getId();
        } else {
            $id2 = $this->crud->getId();
        }
        return Redirect::to($this->getSessionUrl());
    }


    public function update(Request $request, $id = null, $id2 = null)
    {
        // Set request data
        $this->crud->setData($request->all());

        // Valida data
        $validator = $this->crud->validate();
        $validator->validate();

        // Try update data
        $model_id = $this->getId($id, $id2);
        $this->crud->update($model_id);

        // Success flash message
        Session::flash('success', 'Registro Atualizado com Sucesso');
        return Redirect::to($this->getSessionUrl());
    }


    public function destroy(Request $request, $id = null, $id2 = null)
    {
        // Delete record
        $this->crud->delete($this->getId($id, $id2));

        // Success flash message
        Session::flash('success', 'Registro Removido com Sucesso');

        return Redirect::to($this->getSessionUrl());
    }

    /**
     * getId
     *
     * @param  mixed $id
     * @param  mixed $id2
     * @return mixed
     */
    final function getId($id = null, $id2 = null)
    {
        return is_null($id2) ? $id : $id2;
    }
}