<?php

namespace Scriptpage\Repository;

use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\traitActionable;
use Illuminate\Database\Eloquent\Model;
use Scriptpage\Contracts\traitWithAttributes;
use Scriptpage\Repository\Crud\traitCrud;

abstract class BaseRepository implements IRepository
{
    use traitCrud;
    use traitActionable;
    // use traitWithAttributes;

    protected Model $model;
    protected Builder $builder;
    protected string $modelClass;
    private $urlQuery;
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
    final public function setUrlQueryFilter(bool $urlQueryFilter): self
    {
        $this->urlQueryFilter = $urlQueryFilter;
        return $this;
    }

    final public function setUrlQuery(array $urlQuery): self
    {
        $this->urlQuery = $urlQuery;
        return $this;
    }

    final public function setTake($take): self
    {
        $this->take = $take;
        return $this;
    }

    /**
     * paginate
     * @param  $paginate
     * @return self
     */
    final public function setPaginate(bool $paginate): self
    {
        $this->paginate = $paginate;
        return $this;
    }

    final public function getPaginate()
    {
        return $this->paginate;
    }

    /**
     * Summary of getModel
     * @return Model
     */
    final public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * getBuilder
     * @return Builder
     */
    final public function getBuilder(): Builder
    {
        if (empty($this->builder))
            $this->builder = $this->newQuery();

        return $this->builder;
    }

    /**
     * @return Builder
     */
    final public function newQuery(): Builder
    {
        unset($this->builder);

        // Illuminate\Database\Eloquent\Builder
        $this->builder = $this->model->newQuery();

        return $this->builder;
    }

    /**
     * @return Builder
     */
    final public function newDB(): Builder
    {
        unset($this->builder);

        // Illuminate\Database\Query\Builder
        $this->builder = DB::table($this->model->getTable());

        return $this->builder;
    }

    /**
     * Summary of with
     * @param | $relations
     * @return BaseRepository
     */
    final public function with(array|string $relations): self {
        $model = $this->getModel();
        $model->with($relations);
        return $this;
    }

    /**
     * Summary of doQuery
     * @param mixed $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    final public function doQuery(array $filters = [])
    {
        $this->applyFilters($filters);

        $result = [];
        $builder = $this->getBuilder();
        $take = ($this->take > 0) ? $this->take : null;

        if ($this->paginate) {
            $paginator = $builder->paginate($take);
            $result = $paginator->appends(
                array_merge($this->urlQuery ?? [], $this->appends())
            );
        } else {
            $builder = $builder->take($take);
            $result = $builder->get();
        }

        return $result;
    }

    protected function appends(): array
    {
        return array();
    }

    final public function toSql(): array
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
    final function applyFilters(array $filters = []): self
    {
        $data = $this->urlQueryFilter ? $this->urlQuery : [];
        $data['paginate'] = $data['paginate'] ?? 'true';
        $data['take'] = $data['take'] ?? 5;
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
        return call_user_func_array([$this->model, $method], $arguments);
    }
}