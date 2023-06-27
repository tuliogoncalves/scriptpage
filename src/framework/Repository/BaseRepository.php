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

use App\Models\User;
use Exception;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Scriptpage\Assets\traitValidation;
use Scriptpage\Contracts\IRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as IValidator;

abstract class BaseRepository implements IRepository
{
    use traitValidation;

    private Model $model;
    private Builder $builder;

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
    protected $ignoreValidation = false;

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
        if (!$this->authorize()) {
            $this->failedAuthorization();
        }

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
    private function runQuery(array $filters = []): LengthAwarePaginator|Collection
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
            'data' => $builder->toSql(),
            'bindings' => $builder->getBindings()
        ];
    }

    final public function existsCustomFilter(string $customFilter)
    {
        return in_array($customFilter, $this->customFilters);
    }

    /**
     * Get valition class
     *
     * @return Validation
     */
    private function getValidation(string $class)
    {
        $this->validation = new $class;
        if (!$this->validation instanceof Validation) {
            $this->failedValidation('must be an instance of Scriptpage\\repository\\Validation', [
                'class: ' . get_class($this->validation)
            ], 500);
        }
        return $this->validation;
    }

    /**
     * Prepare validation and create validator
     * @param mixed $validationKey
     * @param mixed $data
     * @return BaseRepository|Validation
     */
    private function makeValidation($validationKey = null, $data = [])
    {
        $validation = null;
        $validationClass = $this->validationClass[$validationKey] ?? null;

        if (isset($validationClass)) {
            $validation = $this->getValidation($validationClass);
        } else {
            $validation = $this;
        }

        $validation->fill($this->dataPayload);
        $validation->setDataPayload($this->getInputs());

        if (!$validation->authorize()) {
            $this->failedAuthorization();
        }

        $this->validator = Validator::make(
            array_merge($data, $validation->getDataPayload()),
            $validation->getRules(),
            $validation->messages(),
            $validation->attributes()
        )->stopOnFirstFailure($this->stopOnFirstFailure);

        $validation->withValidator($this->validator);

        return $validation;
    }

    /**
     * @return mixed
     */
    public function getValidator($validationKey = null, $data = [])
    {
        if (!isset($this->validator))
            $this->makeValidation($validationKey, $data);
        return $this->validator;
    }

    /**
     * create a new instance
     * @param array $attributes
     * @return Model
     */
    public function create(array $data = [])
    {
        return $this->model->newInstance()->forceFill($data);
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
        $validation = $this->makeValidation($validationKey, $data);

        if (!$this->ignoreValidation) {
            $validator = $this->getValidator();
            if ($validator->fails())
                $this->failedValidation(
                    '400 Validator fails',
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
        $validation = $this->makeValidation($validationKey, $data);

        if (!$this->ignoreValidation) {
            $validator = $this->getValidator();
            if ($validator->fails())
                $this->failedValidation(
                    '400 Validator fails',
                    $validator->errors()->toArray()
                );
        }

        $model = $this->model->findOrFail($id);
        $model->fill(array_merge($data, $validation->getDataPayload()));
        $model->save();

        return $model;
    }

    public function delete($key)
    {
        return $this->model->destroy($key);
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
        $result = call_user_func_array([$this->model, $method], $arguments);

        if ($result instanceof EloquentBuilder)
            $this->builder = $result;
        if ($result instanceof Model)
            $this->model = $result;

        return $result;
    }

}