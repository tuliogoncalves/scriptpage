<?php

namespace App\Scriptpage\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

trait traitCrud
{
    /**
     * store
     * @param mixed $id
     * @param mixed $id2
     * @return RedirectResponse
     */
    final function crudStore(Request $request, $id = null, $id2 = null)
    {
        // Create object
        $this->crud->create();

        // Set request data
        $this->crud->fill($request->all());

        // Valida data
        $validator = $this->crud->validate();
        $validator->validate();

        // Try storage new data
        $this->crud->store();

        // Success flash message
        Session::flash('success', 'Record Added Successfully.');
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
    final function crudUpdate(Request $request, $id = null, $id2 = null)
    {
        // Get Object
        $key = $this->getModelId($id, $id2);
        $this->crud->read($key);

        // Set request data
        $this->crud->fill($request->all());

        // Valida data
        $validator = $this->crud->validate();
        $validator->validate();

        // Update data
        $this->crud->update();

        // Success flash message
        Session::flash('success', 'Registration Successfully Updated.');
    }


    /**
     * destroy
     *
     * @param  mixed $request
     * @param  mixed $id
     * @param  mixed $id2
     * @return RedirectResponse
     */
    final function crudDestroy(Request $request, $id = null, $id2 = null)
    {
        // Success flash message
        if( $this->crud->delete($this->getModelId($id, $id2)) ) {
            Session::flash('success', 'Successfully Deleted Record.');
        } else {
            Session::flash('fail', 'Fail Deleting Record.');
        }
    }


    /**
     * getModelId
     *
     * @param  mixed $id
     * @param  mixed $id2
     * @return mixed
     */
    final function getModelId($id = null, $id2 = null)
    {
        return is_null($id2) ? $id : $id2;
    }
}
