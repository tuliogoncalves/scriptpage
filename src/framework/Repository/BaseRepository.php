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
    private $data;
    private $take = 5;
    private $paginate = true;
    protected $urlQueryFilter = false;

    function __construct()
    {
        $this->model = app($this->modelClass);
    }

    /**
     * @param mixed $urlQueryFilter 
     * @return self
     */
    public function setUrlQueryFilter(bool $urlQueryFilter): self
    {
        $this->urlQueryFilter = $urlQueryFilter;
        return $this;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
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
        if (empty($this->builder))
            $this->builder = $this->newQuery();

        return $this->builder;
    }

    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        unset($this->builder);

        // Illuminate\Database\Eloquent\Builder
        $this->builder = $this->model->newQuery();

        return $this->builder;
    }

    /**
     * @return Builder
     */
    public function newDB(): Builder
    {
        unset($this->builder);

        // Illuminate\Database\Query\Builder
        $this->builder = DB::table($this->model->getTable());

        return $this->builder;
    }


    /**
     * Summary of doQuery
     * @param mixed $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function doQuery(array $filters = [])
    {
        $this->applyFilters($filters);

        $builder = $this->getBuilder();
        $result = [];

        if ($this->paginate) {
            $perPage = ($this->take > 0) ? $this->take : 1;
            $paginator = $builder->paginate($perPage);
            $result = $paginator->appends(
                array_merge($this->data ?? [], $this->appends())
            );
        } else {
            if ($this->take > 0)
                $builder = $builder->take($this->take);
            $result = $builder->get();
        }

        return $result;
    }

    protected function appends(): array
    {
        return array();
    }

    public function toSql(): array
    {
        if ($this->urlQueryFilter)
            $this->applyFilters();

        $builder = $this->getBuilder();
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
    function applyFilters(array $filters = []): self
    {
        $data = $this->urlQueryFilter ? $this->data : [];
        $data['paginate'] = $this->data['paginate'] ?? 'true';
        $data['take'] = $this->data['take'] ?? 5;

        $urlQueryFilter = new UrlQueryFilter();
        $urlQueryFilter->apply($this, array_merge($data, $filters));
        return $this;
    }

    /**
     * Trigger static method calls to the model
     *
     * @param $method
     * @param $arguments
     *
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
        return call_user_func_array([$this->getBuilder(), $method], $arguments);
    }
}