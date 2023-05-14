<?php

namespace App\Scriptpage\Repository;

use App\Scriptpage\Contracts\IRepository;
use App\Scriptpage\Contracts\traitActionable;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
implements IRepository
{
    use traitActionable;

    /**
     * Model class for repo.
     *
     * @var string
     */
    protected string $modelClass;


    /**
     * Model key
     */
    protected $key;



    /**
     * Eloquent Model instance
     */
    protected Model $object;


    /**
     * with
     *
     * @var array
     */
    protected $with = [];




    /**
     * Eloquent model instance
     */
    protected $model;


    /**
     * with
     * 
     * @param Array|String $with
     *
     * @return Repository
     */
    function with($with = [])
    {
        if (is_string($with)) $with = explode(',', $with);
        $this->with = $with;
        return $this;
    }


    /**
     * load default class dependencies.
     *
     * @dependencies Model $model Illuminate\Database\Eloquent\Model
     */
    function __construct()
    {
        if (!empty($this->modelClass)) {
            $this->model = app($this->modelClass);
        }
    }


    /**
     * getKey
     * 
     * @return mixed
     */ 
    function getKey() {
        return $this->key;
    }

    /**
     * Request paginate data.
     */
    protected $search;
    protected $take = 5;
    protected $paginate = true;

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    final function newQuery($table = '')
    {
        if ($table <> '') {
            // QueryBuilder
            $query = DB::table($table);
        } else {
            // EloquentQueryBuilder
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
    final function doQuery($query = null, $take = null, $paginate = null)
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
        return array();
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
    final function getAll($take = null, $paginate = null)
    {
        return $this->doQuery(null, $take, $paginate);
    }


    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    final function lists($column, $key = null)
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
    final function find($id, $fail = true)
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
     * @return Collection|EloquentCollection|Paginator
     */
    function getData($take = null, $paginate = null)
    {
        return $this->getAll();
    }

}
