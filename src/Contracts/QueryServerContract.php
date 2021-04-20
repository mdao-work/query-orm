<?php


namespace mdao\QueryBuilder\Contracts;


use mdao\QueryBuilder\Entities\QueryFilter;
use mdao\QueryBuilder\Entities\QueryOrderBy;
use mdao\QueryBuilder\Entities\QueryPagination;
use mdao\QueryBuilder\Entities\QuerySelect;

interface QueryServerContract
{
    /**
     * 条件
     * @return array
     */
    public function getQueryFilter(): array;

    /**
     * 排序
     * @return QueryOrderBy|null
     */
    public function getQueryOrderBy(): ?QueryOrderBy;

    /**
     * 分页
     * @return QueryPagination|null
     */
    public function getQueryPagination(): ?QueryPagination;

    /**
     * 字段
     * @return QuerySelect|null
     */
    public function getQuerySelect(): ?QuerySelect;

}