<?php

namespace Scriptpage\Repository;

use Illuminate\Database\Query\Builder;
use Scriptpage\Contracts\IRepository;
use Scriptpage\Contracts\traitActionable;
use Scriptpage\Repository\Filters\SelectFilter;

class UrlFilter 
{
    use traitActionable;

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

    public function apply(IRepository $repository, Array $parameters)
    {
        $builder = $repository->getModel();
        // refatorar: inicializar a query builder, 
        // passar ela por parametro recebe-la e 
        // atualizar o atributo querybuilder da classe baseRepository
        foreach ($parameters as $filter => $values) {
            $builder = app($this->filters[$filter])->apply($repository, $values);
        }
        return $builder;
    }
}
