<?php

namespace Scriptpage\Repository;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
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
     * Summary of builder
     * @var Builder
     */
    protected Builder $builder;

    /**
     * Model class for repo.
     *
     * @var string
     */
    protected string $modelClass;

    /**
     * Summary of take
     * @var int
     */
    private $take = 5;

    /**
     * Summary of paginate
     * @var 
     */
    private $paginate = true;

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
	 * @param mixed $take 
	 * @return self
	 */
	public function setTake($take): self {
		$this->take = $take;
		return $this;
	}

    /**
	 * paginate
	 * @param  $paginate
	 * @return self
	 */
	public function setPaginate(bool $paginate): self {
		$this->paginate = $paginate;
		return $this;
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
	 * getBuilder
	 * @return Builder
	 */
	public function getBuilder(): Builder {
		return $this->builder;
	}

    /**
     * @return Builder
     */
    final public function newQuery(): Builder
    {
        // Illuminate\Database\Eloquent\Builder
        $this->builder = $this->model->newQuery();
        
        return $this->builder;
    }

    /**
     * @return Builder
     */
    final public function newQueryDB(): Builder
    {
        // Illuminate\Database\Query\Builder
        $this->builder = DB::table($this->model->getTable());

        return $this->builder;
    }


    /**
     * Execute Query Builder
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|
     *          \Illuminate\Database\Eloquent\Collection|array<\Illuminate\Database\Eloquent\Builder>
     */
    final public function doQuery()
    {
        $builder= $this->builder;

        if ($this->paginate) {
            $paginator = $builder->paginate($this->take);
            return $paginator->appends($this->appends());
        }

        if ($this->take > 0) {
            $builder->take($this->take);
        }

        return $builder->get();
    }

    /**
     * @return array()
     */
    protected function appends()
    {
        return array();
    }

    /**
     * Summary of urlQuery
     * @param array $query
     * @return BaseRepository
     */
    function urlFilter(array $parameters = [])
    {
        $urlFilter = new UrlFilter($this);
        $urlFilter->apply($parameters);
        return $this;
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