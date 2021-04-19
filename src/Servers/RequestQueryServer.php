<?php


namespace mdao\QueryBuilder\Servers;

use mdao\QueryBuilder\Contracts\QueryServerContract;
use mdao\QueryBuilder\Entities\QueryFilter;
use mdao\QueryBuilder\Entities\QueryOrderBy;
use mdao\QueryBuilder\Entities\QueryPagination;
use mdao\QueryBuilder\Entities\QuerySelect;

class RequestQueryServer  implements QueryServerContract
{


    public function getQueryFilter(): ?QueryFilter
    {

    }

    public function getQueryOrderBy(): ?QueryOrderBy
    {
        // TODO: Implement getQueryOrderBy() method.
    }

    public function getQueryPagination(): ?QueryPagination
    {
        // TODO: Implement getQueryPagination() method.
    }

    public function getQuerySelect(): ?QuerySelect
    {
        // TODO: Implement getQuerySelect() method.
    }
}