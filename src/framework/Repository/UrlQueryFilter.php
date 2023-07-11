<?php

namespace Scriptpage\Repository;

use Scriptpage\Contracts\IRepository;
use Scriptpage\Repository\Filters\GroupByFilter;
use Scriptpage\Repository\Filters\HavingFilter;
use Scriptpage\Repository\Filters\JoinFilter;
use Scriptpage\Repository\Filters\LeftJoinFilter;
use Scriptpage\Repository\Filters\OrderByFilter;
use Scriptpage\Repository\Filters\OrHavingFilter;
use Scriptpage\Repository\Filters\OrWhereFilter;
use Scriptpage\Repository\Filters\PaginateFilter;
use Scriptpage\Repository\Filters\RightJoinFilter;
use Scriptpage\Repository\Filters\SelectFilter;
use Scriptpage\Repository\Filters\SkipFilter;
use Scriptpage\Repository\Filters\TakeFilter;
use Scriptpage\Repository\Filters\WhereFilter;
use Scriptpage\Repository\Filters\WithCountFilter;
use Scriptpage\Repository\Filters\WithFilter;
use Scriptpage\Repository\Filters\WithSumFilter;
use Scriptpage\Repository\Filters\CustomFilter;

class UrlQueryFilter
{
    // use traitActionable;

    private $filters = [
        'select' => SelectFilter::class,
        'with' => WithFilter::class,
        'withCount' => WithCountFilter::class,
        'withSum' => WithSumFilter::class,
        'where' => WhereFilter::class,
        'orWhere' => OrWhereFilter::class,
        'join' => JoinFilter::class,
        'leftJoin' => LeftJoinFilter::class,
        'rightJoin' => RightJoinFilter::class,
        'take' => TakeFilter::class,
        'skip' => SkipFilter::class,
        'orderBy' => OrderByFilter::class,
        'groupBy' => GroupByFilter::class,
        'having' => HavingFilter::class,
        'orHaving' => OrHavingFilter::class,
        'paginate' => PaginateFilter::class
    ];

    public function apply(IRepository $repository, array $parameters)
    {
        $builder = $repository->getBuilder();
        foreach ($parameters as $filter => $values) {
            // isFilter
            if (isset($this->filters[$filter]))
            {
                $queryFilter = new $this->filters[$filter];
                if(is_array($values)) {
                    foreach ($values as $value) {
                        $value = $value ?? '';
                        $builder = $queryFilter->apply($repository, $value);
                    }
                } else {
                    $builder = $queryFilter->apply($repository, $values);
                }
            }
            // isCustomFilter
            else {
                if(method_exists($repository, $filter) and $repository->existsCustomFilter($filter)){
                    $customFilter= new CustomFilter();
                    $builder = $customFilter->customApply($repository, $filter, $values ?? "");
                }
            }
        }
        return $builder;
    }
}
