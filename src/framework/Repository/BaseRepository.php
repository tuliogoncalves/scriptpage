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

use Error;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Scriptpage\Contracts\IRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class BaseRepository extends Validation implements IRepository
{
    private Model $model;
    private $builder;

    private $inputs = [];
    private $filters = [];
    private int $take = 5;
    private int $skip = 0;
    private $paginate = true;

    protected $validator;

    protected $modelClass;
    protected $validationClass = [];
    protected $allowFilters = false;
    protected $customFilters = [];
    protected $stopOnFirstFailure = false;
    protected $ignoreValidationException = false;

    function __construct()
    {
        $this->model = new $this->modelClass;
    }

    /**
     * Define validation rules
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Define allows to use Filters in URL
     * @param mixed $applyFilters
     * @return self
     */
    final public function setAllowFilters(bool $allowFilters): self
    {
        $this->allowFilters = $allowFilters;
        return $this;
    }

    /**
     * Set data of query string in URL
     * @param array $filters
     * @return self
     */
    final public function setFilters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Get all of the input and files for the request.
     * @return array
     */
    final public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * Set all of the input and files for the request.
     * @param mixed $data 
     * @return self
     */
    final public function setInputs(array $inputs)
    {
        $this->inputs = $inputs;
        return $this;
    }

    final public function setTake($take): self
    {
        $this->take = (int) $take;
        return $this;
    }

    final public function setSkip($offset): self
    {
        $this->skip = (int) $offset;
        return $this;
    }

    /**
     * Set paginate
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

    final public function getBuilder()
    {
        if (empty($this->builder))
            $this->builder = $this->newQuery();

        return $this->builder;
    }

    final public function newQuery()
    {
        // Illuminate\Database\Eloquent\Builder
        $this->builder = $this->model->newQuery();

        return $this->builder;
    }

    final public function newDB()
    {
        // Illuminate\Database\Query\Builder
        $this->builder = DB::table($this->model->getTable());

        return $this->builder;
    }

    /**
     * isEloquentBuilder
     * @return bool
     */
    private function isEloquentBuilder()
    {
        return get_class($this->getBuilder()) == 'Illuminate\Database\Eloquent\Builder';
    }

    /**
     * isQueryBuilder (DB)
     * @return bool
     */
    private function isQueryBuilder()
    {
        return get_class($this->getBuilder()) == 'Illuminate\Database\Query\Builder';
    }

    /**
     * Summary of with
     * @param array|string $relations
     * @return BaseRepository
     */
    final public function with($relations): self
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
    final public function doQuery(array $filters = [])
    {
        // Throw Authorization Exception 
        if (!$this->authorize()) {
            $this->failedAuthorization();
        }

        // Throw Authorization Exception 
        if (!$this->allowFilters and $this->isQueryBuilder()) {
            $this->failedAuthorization();
        }

        return $this->runQuery($filters);
    }

    /**
     * Summary of runQuery
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    private function runQuery(array $filters = [])
    {
        $this->applyFilters($filters);

        $result = [];
        $builder = $this->getBuilder();
        $take = ($this->take > 0) ? $this->take : null;

        // With paginate result
        if ($this->isEloquentBuilder() and $this->paginate) {
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
            'data' => [
                'sql' => $builder->toSql(),
                'bindings' => $builder->getBindings()
            ]
        ];
    }

    public function existsCustomFilter(string $customFilter)
    {
        return in_array($customFilter, $this->customFilters);
    }

    /**
     * Get valition class
     *
     * @return Validation
     */
    private function getValidation(string $validationKey)
    {
        $validation = null;
        $validationClass = $this->validationClass[$validationKey] ?? null;

        try {
            $validation = isset($validationClass)
                ? new $validationClass
                : $this;
        } catch (Error $e) {
            $this->failedRepository('An error occurred creating instance of validation', [
                'validationClass' => $validationClass
            ]);
        }

        if (!$validation instanceof Validation)
            $this->failedRepository('The class must be an instance of Scriptpage\\repository\\Validation', [
                'validationClass' => $validationClass
            ]);

        $validation->fill($this->getDataPayload() ?? []);

        return $validation;
    }

    // private function makeValidation(array $data = [], string $validationKey)
    // {
    //     $validation = $this->getValidation($validationKey);
    //     $validation = $this->runValidation($data, $validation);
    //     return $validation;
    // }

    public function getValidator(string $validationKey = '', array $data = [])
    {
        if (!isset($this->validator))
            $this->validator = $this->runValidation($data, $validationKey);

        return $this->validator;
    }

    private function runValidation(array $data, string $validationKey)
    {
        $validation = $this->getValidation($validationKey);

        // Throw Authorization Exception 
        if (!$validation->authorize()) {
            $this->failedAuthorization();
        }

        $validator = Validator::make(
            array_merge($data, $validation->getDataPayload()),
            $validation->getRules(),
            $validation->messages(),
            $validation->attributes()
        )->stopOnFirstFailure($this->stopOnFirstFailure);

        $validation->withValidator($validator);

        return $validator;
    }

    /**
     * create a new instance
     * @param array $attributes
     * @return Model
     */
    public function create(array $data = [])
    {
        return $this->model->getModel()->newInstance()->fill($data);
    }

    /**
     * Summary of store
     * @param array $data
     * @param string $validationKey
     * @return Model
     */
    public function store(array $data = [], string $validationKey = 'store')
    {
        $model = null;
        $validator = $this->getValidator($validationKey, $data);
        $validation = $this->getValidation($validationKey);

        if (!$this->ignoreValidationException) {
            if ($validator->fails())
                $this->failedValidation(
                    '400 Validator fails to store',
                    $validator->errors()->toArray()
                );
        }

        $model = $this->create(array_merge($data, $validation->getDataPayload()));
        $model->save();

        return $model;
    }

    /**
     * update data to the database
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data = [], string $validationKey = 'update')
    {
        $model = null;
        $validator = $this->getValidator($validationKey, $data);
        $validation = $this->getValidation($validationKey);

        if (!$this->ignoreValidationException) {
            if ($validator->fails())
                $this->failedValidation(
                    '400 Validator fails to update',
                    $validator->errors()->toArray()
                );
        }

        $model = $this->model->findOrFail($id);
        $model->fill(array_merge($data, $validation->getDataPayload()));
        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->model->findOrFail($id);
        return $model->destroy($id);
    }

    /**
     * make
     *
     * @return self
     */
    public static function make(): self
    {
        return new static();
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
        // Throw Authorization Exception 
        if (!$this->authorize()) {
            $this->failedAuthorization();
        }

        $result = call_user_func_array([$this->model, $method], $arguments);

        if ($result instanceof EloquentBuilder)
            $this->builder = $result;
        if ($result instanceof Model)
            $this->model = $result;

        return $result;
    }

}