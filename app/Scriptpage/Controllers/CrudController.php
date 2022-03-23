<?php

namespace App\Scriptpage\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class CrudController extends BaseController
{

    /**
     * create
     * @param Request $request
     * @param mixed $id
     * @param mixed $id2
     * @return Response
     */
    public function create(Request $request, $id = null, $id2 = null)
    {
        return $this->render(
            $this->template . '/form',
            $this->dataCreate($request, $id, $id2)
        );
    }


    /**
     * show
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return Response
     */
    public function show(Request $request, $id = null, $id2 = null)
    {
        return $this->edit($request, $id, $id2);
    }


    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return Response
     */
    public function edit(Request $request, $id, $id2 = null)
    {
        return $this->render(
            $this->template . '/form',
            $this->dataEdit($request, $id, $id2)
        );
    }


    /**
     * store
     * @param mixed $id
     * @param mixed $id2
     * @return RedirectResponse
     */
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

        return Redirect::to($this->getUrl('store', $id, $id2));
    }


    /**
     * update
     *
     * @param mixed $request
     * @param mixed $id
     * @param mixed $id2
     * @return RedirectResponse
     * @throws ValidationException
     */
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

        return Redirect::to($this->getUrl('update', $id, $id2));
    }


    /**
     * destroy
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return RedirectResponse
     */
    public function destroy(Request $request, $id = null, $id2 = null)
    {
        // Delete record
        $this->crud->delete($this->getId($id, $id2));

        // Success flash message
        Session::flash('success', 'Registro Removido com Sucesso');

        return Redirect::to($this->getUrl('destroy', $id, $id2));
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


    /**
     * dataCreate
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return array
     */
    protected function dataCreate(Request $request, $id = null, $id2 = null): array
    {
        return [
            'data' => $this->crud->create()
        ];
    }


    /**
     * dataEdit
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return array
     */
    protected function dataEdit(Request $request, $id, $id2 = null): array
    {
        return [
            'data' => $this->repository->find($id)
        ];
    }
}
