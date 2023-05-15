<?php

namespace Scriptpage\Repository;

use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\traitActionable;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IRepository
{
    use traitActionable;

    /**
     * Model instance
     */
    protected Model $model;

    /**
     * Model class for repo.
     *
     * @var string
     */
    protected string $modelClass;

    protected $take = 5;
    protected $paginate = true;

    /**
     * load default class dependencies.
     *
     * @dependencies Model $model Illuminate\Database\Eloquent\Model
     */
    function __construct()
    {
        $this->model = app($this->modelClass);
    }

    /**
     * Summary of getModel
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return array()
     */
    protected function appends()
    {
        return array();
    }

    /**
     * Execute the database/eloquent query
     *
     * @return void
     */
    final public function doQuery()
    {
        $model = $this->model;

        if ($this->paginate) {
            $paginator = $model->paginate($this->take);
            return $paginator->appends($this->appends());
        }

        if ($this->take > 0) {
            $model->take($this->take);
        }

        return $model::get();
    }

    /**
     * Summary of urlQuery
     * @param array $query
     * @return BaseRepository
     */
    function urlQuery(array $query = [])
    {
        return UrlFilter::make()->apply($this, $query);
    }

    /**
     * Trigger static method calls to the model
     * @param mixed $method
     * @param mixed $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([new static(), $method], $arguments);
    }

    /**
     * Trigger method calls to the model
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->model, $method], $arguments);
    }
}