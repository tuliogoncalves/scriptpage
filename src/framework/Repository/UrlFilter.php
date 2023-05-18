<?php

namespace Scriptpage\Repository;

use Illuminate\Contracts\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\traitActionable;
use Scriptpage\Repository\Filters\PaginateFilter;
use Scriptpage\Repository\Filters\SelectFilter;
use Scriptpage\Repository\Filters\TakeFilter;
use Scriptpage\Repository\Filters\WithFilter;

class UrlFilter
{
    use traitActionable;

    private IRepository $repository;

    private $filters = [
        'select' => SelectFilter::class,
        'with' => WithFilter::class,
        'withCount' => WithCountFilter::class,
        'withSum' => WithSumFilter::class,
        'where' => WhereFilter::class,
        'orWhere' => OrWhereFilter::class,
        'join' => JoinFilter::class,
        'leftJoin' => LeftFilter::class,
        'rightJoin' => RightJoinFilter::class,
        'take' => TakeFilter::class,
        'orderBy' => OrderByFilter::class,
        'paginate' => PaginateFilter::class
    ];

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    public function apply(array $parameters): Builder
    {
        $builder = $this->repository->getBuilder();
        foreach ($parameters as $filter => $values) {
            if (isset($this->filters[$filter]))
                $builder = app($this->filters[$filter])->apply($this->repository, $values);
        }
        return $builder;
    }
}
