<?php

namespace Scriptpage\Query;

use Illuminate\Contracts\Database\Query\Builder as IBuilder;
use Scriptpage\Query\Filters\GroupByFilter;
use Scriptpage\Query\Filters\HavingFilter;
use Scriptpage\Query\Filters\JoinFilter;
use Scriptpage\Query\Filters\LeftJoinFilter;
use Scriptpage\Query\Filters\OrderByFilter;
use Scriptpage\Query\Filters\OrHavingFilter;
use Scriptpage\Query\Filters\OrWhereFilter;
use Scriptpage\Query\Filters\PaginateFilter;
use Scriptpage\Query\Filters\RightJoinFilter;
use Scriptpage\Query\Filters\SelectFilter;
use Scriptpage\Query\Filters\SkipFilter;
use Scriptpage\Query\Filters\TakeFilter;
use Scriptpage\Query\Filters\WhereFilter;
use Scriptpage\Query\Filters\WithCountFilter;
use Scriptpage\Query\Filters\WithFilter;
use Scriptpage\Query\Filters\WithSumFilter;
use Scriptpage\Query\Filters\CustomFilter;

class UrlFilterApply
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

    private UrlFilter $urlFilter;

    function __construct(UrlFilter $urlFilter) {
        $this->urlFilter = $urlFilter;
    }

    public function apply(array $parameters)
    {
        $builder = $this->urlFilter->getBuilder();
        foreach ($parameters as $filter => $values) {
            // isFilter
            if (isset($this->filters[$filter]))
            {
                $queryFilter = new $this->filters[$filter]($this->urlFilter);
                if(is_array($values)) {
                    foreach ($values as $value) {
                        $value = $value ?? '';
                        $builder = $queryFilter->apply($value);
                    }
                } else {
                    $builder = $queryFilter->apply($values);
                }
            }
            // isCustomFilter
            else {
                if(method_exists($this->urlFilter, $filter) and $this->urlFilter->existsCustomFilter($filter)){
                    $customFilter= new CustomFilter($this->urlFilter);
                    $builder = $customFilter->customApply($filter, $values ?? "");
                }
            }
        }
        return $builder;
    }
}
