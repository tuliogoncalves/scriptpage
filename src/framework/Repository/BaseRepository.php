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

    protected Model $model;
    protected Builder $builder;
    protected string $modelClass;
    private $requestData;
    private $take = 5;
    private $paginate = true;

    function __construct()
    {
        $this->model = app($this->modelClass);
    }

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
        if(empty($this->builder)) 
            $this->builder = $this->newQuery();

        return $this->builder;
    }

    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        // Illuminate\Database\Eloquent\Builder
        $this->builder = $this->model->newQuery();
        
        return $this->builder;
    }

    /**
     * @return Builder
     */
    public function newDB(): Builder
    {
        // Illuminate\Database\Query\Builder
        $this->builder = DB::table($this->model->getTable());

        return $this->builder;
    }


    /**
     * Summary of doQuery
     * @return array
     */
    public function doQuery(): array
    {
        $builder = $this->builder;
        $result = [];

        try {
            if ($this->paginate) {
                $paginator = $builder->paginate($this->take);
                $result = $paginator->appends(
                    array_merge($this->requestData ?? [], $this->appends())
                );
                $result = $result->toArray();
            } else {
                if ($this->take > 0) {
                    $builder->take($this->take);
                }
                $result = $builder->get()->flatten(1);
                $result = [
                    'data' => $result->toArray()
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

    protected function appends(): array
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
        $this->requestData = $parameters;
        $urlFilter = new UrlFilter();
        $urlFilter->apply($this, $parameters);
        return $this;
    }

}