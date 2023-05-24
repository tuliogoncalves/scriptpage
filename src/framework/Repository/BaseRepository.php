<?php

namespace Scriptpage\Repository;

use Exception;
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
    public function setTake($take): self
    {
        $this->take = $take;
        return $this;
    }

    /**
     * paginate
     * @param  $paginate
     * @return self
     */
    public function setPaginate(bool $paginate): self
    {
        $this->paginate = $paginate;
        return $this;
    }

    public function getPaginate()
    {
        return $this->paginate;
    }


    /**
     * Summary of getModel
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * getBuilder
     * @return Builder
     */
    public function getBuilder(): Builder
    {
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
        $builder = $this->builder;

        try {
            if ($this->paginate) {
                $paginator = $builder->paginate($this->take);
                $result = $paginator->appends($this->appends());
                $result = $result->toArray();
            } else {
                if ($this->take > 0) {
                    $builder->take($this->take);
                }
                $result = $builder->get()->flatten(1);
                $result = [
                    'data' =>$result->toArray()
                ];
            }
            $result['message'] = 'Success query.';
        } catch (Exception $e) {
            $result = [
                'code' => 500,
                'message' => $e->getMessage()
            ];
        }

        return $result;
    }

    /**
     * @return array()
     */
    protected function appends()
    {
        return array();
    }

    public function toSql()
    {
        $builder = $this->builder;
        return [
            'data' => $builder->toSql(),
            'bindings' => $builder->getBindings()
        ];
    }
    
    /**
     * Summary of urlQuery
     * @param array $query
     * @return BaseRepository
     */
    function urlFilter(array $parameters = []): self
    {
        $urlFilter = new UrlFilter($this);
        $urlFilter->apply($parameters);
        return $this;
    }

}