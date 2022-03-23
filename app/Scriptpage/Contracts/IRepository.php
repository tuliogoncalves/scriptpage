<?php

namespace App\Scriptpage\Contracts;

interface IRepository
{
    /**
     * Start new query
     */
    function newQuery($table = '');


    /**
     * Exec query
     *
     * @param int  $take
     * @param bool $paginate
     *
     */
    function doQuery($query = null, $take = null, $paginate = null);


    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int  $take
     * @param bool $paginate
     *
     */
    function getAll($take = null, $paginate = null);


    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return Model
     */
    function find($id, $fail = true);


    /**
     * @param int   $take
     * @param bool  $paginate
     *
     * @return mixed
     */
    function getData($take = null, $paginate = null);
}
