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
    protected $urlQueryFilter = false;

    function __construct()
    {
        $this->model = app($this->modelClass);
    }

	/**
	 * @param mixed $urlQueryFilter 
	 * @return self
	 */
	public function setUrlQueryFilter(bool $urlQueryFilter): self {
		$this->urlQueryFilter = $urlQueryFilter;
		return $this;
	}

    public function setRequestData(Array $requestData)
    {
        $this->requestData = $requestData;
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
        if(empty($this->builder)) 
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
     * @return array
     */
    public function doQuery(array $filters = null): array
    {
        if($this->urlQueryFilter) $this->applyFilters($filters);

        $builder = $this->getBuilder();
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
    function applyFilters(array $filters = null): self
    {
        $urlQueryFilter = new UrlQueryFilter();
        // dd($filters ?? $this->requestData);
        $urlQueryFilter->apply($this, $filters ?? $this->requestData);
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