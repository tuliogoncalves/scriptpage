<?php

/*
 * This file is part of scriptpage framework.
 *
 * (c) Túlio Gonçalves <tuliogoncalves@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scriptpage\Query;

use Error;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder as IBuilder;

class UrlFilter
{
    private $builder;

    private $filters = [];
    private int $take = 5;
    private int $skip = 0;
    private $paginate = true;

    /**
     * Set data of query string in URL
     * @param array $filters
     * @return self
     */
    private function setFilters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    public function setTake($take): self
    {
        $this->take = (int) $take;
        return $this;
    }

    public function setSkip($offset): self
    {
        $this->skip = (int) $offset;
        return $this;
    }

    /**
     * Set paginate
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

    public function getBuilder()
    {
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
     * Summary of doQuery
     * @param mixed $filters
     * @return LengthAwarePaginator|Collection|array
     */
    public function doQuery(IBuilder $builder, array $filters = [])
    {
        $request = request();
        $this->setFilters($request->query());
        $this->builder = $builder;

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
            $result = $paginator->appends($this->filters);
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
    function applyFilters(array $filters = []): self
    {
        $data = $this->filters;

        // if (array_key_exists('paginate', $data))
        //     $this->setPaginate($data['paginate'] == 'true');

        // if (array_key_exists('take', $data))
        //     $this->setTake($data['take']);

        // if (array_key_exists('skip', $data))
        //     $this->setSkip($data['skip']);

        $urlQueryFilter = new UrlFilterApply($this);
        $urlQueryFilter->apply(array_merge($data, $filters));

        return $this;
    }

    final public function toSql(): array
    {
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


    static function apply(IBuilder $builder, array $filters = [])
    {
        $urlFilter = new static();
        return $urlFilter->doQuery($builder, $filters);
    }
}
