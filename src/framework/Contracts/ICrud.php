<?php

namespace Scriptpage\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ICrud
{
    /**
     * create objct new model.
     *
     * @return Model.
     */
    function create():array;

    function read():array;

    /**
     * update model in database.
     *
     * @return Model updated item object.
     */
    function update(integer|string $key, array $data=[]):array;

    /**
     * Delete item by primary key id.
     *
     * @param  integer|string $id of primary key.
     * @return boolean
     */
    function destroy(integer|string $key):array;

    /**
     * Persist new model in database.
     *
     * @return Model new model object.
     */
    function store(array $data=[]):array;

    function getModel(): Model;
}
