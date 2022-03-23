<?php

namespace App\Scriptpage\Repository;

use App\Scriptpage\Contracts\IRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class Repository
extends BaseRepository
implements IRepository
{
    /**
     * Request paginate data.
     */
    protected $search;
    protected $take = 5;
    protected $paginate = true;

    
    function requestData(Request $request)
    {
        $this->search = $request->input('search');
        $this->take = (int)$request->input('take', '5');
        $this->paginate = ($request->input('paginate', 'true')) == 'true';
    }


    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    function newQuery($table = '')
    {
        if ($table <> '') {
            $query = DB::table($table);
        } else {
            $query = app($this->modelClass)->newQuery();
            $query->with($this->with);
        }
        return $query;
    }


    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param int                               $take
     * @param bool                              $paginate
     *
     * @return EloquentCollection|Paginator
     */
    function doQuery($query = null, $take = null, $paginate = null)
    {

        if (is_null($query)) {
            $query = $this->newQuery();
        }

        // Consider the default value when no parameter 
        // (repository is mantory)
        $paginate = is_null($paginate) ? $this->paginate : $paginate;
        $take = is_null($take) ? $this->take : $take;

        if ($paginate) {
            $paginator = $query->paginate($take);
            return $paginator->appends($this->appends());
        }

        if ($take > 0) {
            $query->take($take);
        }

        return $query->get();
    }


    /**
     * @return array()
     */
    protected function appends()
    {
        return ['search' => $this->search];
    }


    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int  $take
     * @param bool $paginate
     *
     * @return EloquentCollection|Paginator
     */
    function getAll($take = null, $paginate = null)
    {
        return $this->doQuery(null, $take, $paginate);
    }


    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }


    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int  $id
     * @param bool $fail
     *
     * @return Model
     */
    function find($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }


    /**
     * @param int   $take
     * @param bool  $paginate
     *
     * @return EloquentCollection|Paginator
     */
    function getData($take = null, $paginate = null)
    {
        return $this->getAll();
    }

}
