<?php


namespace mdao\QueryBuilder\Contracts;

use mdao\QueryBuilder\Entities\QueryPagination;
use mdao\QueryBuilder\Entities\QuerySelect;

interface ParserEntityContract
{
    public function apply($param);
}