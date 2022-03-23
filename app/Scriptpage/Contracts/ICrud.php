<?php

namespace App\Scriptpage\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ICrud
{
    /**
     * create new model.
     *
     * @return created new model object.
     */
    function create();


    /**
     * Read an object in database.
     *
     * @return Object model with data.
     */
    function read($id);


    /**
     * update existing item.
     *
     * @param  Integer $id integer item primary key.
     * @return send updated item object.
     */
    function update($id);


    /**
     * Delete item by primary key id.
     *
     * @param  Integer $id integer of primary key.
     * @return boolean
     */
    function delete($id);


    /**
     * Create new record in database.
     *
     * @return Object saved model object with data.
     */
    function store();
}
