<?php

namespace Scriptpage\Repository;

use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\traitActionable;
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

    public function apply(Array $parameters)
    {
        $builder = $this->repository->getBuilder();
        foreach ($parameters as $filter => $values) {
            $builder = app($this->filters[$filter])->apply($builder, $values);
        }
        return $builder;
    }
}
