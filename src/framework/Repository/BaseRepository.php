<?php

/*
 * This file is part of scriptpage framework.
 *
 * (c) Túlio Gonçalves <tuliogoncalves@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scriptpage\Repository;

use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Scriptpage\Contracts\IRepository;
use Illuminate\Database\Eloquent\Model;
use Scriptpage\Exceptions\AuthorizationException;
use Scriptpage\Exceptions\RepositoryException;
use Scriptpage\Repository\Crud\traitCrud;

abstract class BaseRepository implements IRepository
{
    use traitCrud;

    private Model $model;
    private Builder $builder;
    private $filters = [];
    private int $take = 5;
    private int $skip = 0;
    private $paginate = true;

    protected $modelClass;
    protected $allowFilters = false;
    protected $customFilters = [];

    function __construct()
    {
        $this->model = new $this->modelClass;
    }

    /**
     * Summary of setApplyFilters
     * @param mixed $applyFilters
     * @return self
     */
    final public function setAllowFilters(bool $allowFilters): self
    {
        $this->allowFilters = $allowFilters;
        return $this;
    }

    final public function setFilters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    final public function setTake($take): self
    {
        $this->take = $take;
        return $this;
    }

    final public function setSkip($offset): self
    {
        $this->skip = $offset;
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
        // Illuminate\Database\Eloquent\Builder
        $this->builder = $this->model->newQuery();

        return $this->builder;
    }

    /**
     * @return Builder
     */
    final public function newDB(): Builder
    {
        // Illuminate\Database\Query\Builder
        $this->builder = DB::table($this->model->getTable());

        return $this->builder;
    }

    /**
     * Summary of with
     * @param array|string $relations
     * @return BaseRepository
     */
    final public function with(array|string $relations): self
    {
        $builder = $this->getBuilder();
        $this->builder = $builder->with($relations);
        return $this;
    }

    /**
     * Summary of doQuery
     * @param mixed $filters
     * @return LengthAwarePaginator|Collection|array
     */
    final public function doQuery(array $filters = []): LengthAwarePaginator|Collection|array
    {
        if (!$this->passesAuthorization()) {
            $this->failedAuthorization();
        }

        try {
            return $this->runQuery($filters);
        } catch (Exception $e) {
            throw new RepositoryException(
                $e->getMessage() . '.Error code:' . $e->getCode(),
                $e->getCode()
            );
        }
    }

    /**
     * Summary of runQuery
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    private function runQuery(array $filters = []): LengthAwarePaginator|Collection
    {
        $this->applyFilters($filters);

        $result = [];
        $builder = $this->getBuilder();
        $take = ($this->take > 0) ? $this->take : null;

        // With paginate result
        if (
            get_class($builder) == 'Illuminate\Database\Eloquent\Builder'
            and $this->paginate
        ) {
            $paginator = $builder->paginate($take);
            $result = $paginator->appends(
                array_merge($this->filters, $this->appends())
            );
        }
        // No paginate result
        else {
            $builder = $builder->take($take);
            if ($this->skip > 0)
                $builder = $builder->skip($this->skip);
            $result = $builder->get();
        }

        return $result;
    }

    /**
     * applyFilters
     * @param array $query
     * @return self
     */
    final function applyFilters(array $filters = []): self
    {
        $data = $this->filters;

        if (array_key_exists('paginate', $data))
            $this->setPaginate($data['paginate'] == 'true');

        if (array_key_exists('take', $data))
            $this->setTake($data['take']);

        if (array_key_exists('skip', $data))
            $this->setSkip($data['skip']);

        if ($this->allowFilters) {
            $urlQueryFilter = new UrlQueryFilter();
            $urlQueryFilter->apply($this, array_merge($data, $filters));
        }

        return $this;
    }

    protected function appends(): array
    {
        return array();
    }

    final public function toSql(): array
    {
        if ($this->allowFilters)
            $this->applyFilters();

        $builder = $this->getBuilder();

        return [
            'data' => $builder->toSql(),
            'bindings' => $builder->getBindings()
        ];
    }

    final public function existsCustomFilter(string $customFilter)
    {
        return in_array($customFilter, $this->customFilters);
    }

    /**
     * Determine if the request passes the authorization check.
     *
     * @return bool
     */
    function passesAuthorization()
    {
        if (method_exists($this, 'authorize')) {
            return $this->authorize();
        }

        return true;
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException(null, $code = 403);
    }

    /**
     * Trigger method calls to the attributes model
     * @param mixed $key
     * @param mixed $value
     * @return BaseRepository
     */
    public function __set($key, $value)
    {
        $model = $this->model;
        $model->$key = $value;
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
     * Trigger method calls to the model or builder
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $result = call_user_func_array([$this->model, $method], $arguments);

        if ($result instanceof EloquentBuilder)
            $this->builder = $result;
        if ($result instanceof Model)
            $this->model = $result;

        return $result;
    }
}