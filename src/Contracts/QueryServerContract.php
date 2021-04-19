<?php


namespace mdao\Contracts\QueryBuilder;


interface QueryServerContract
{
    public function getQueryItems(): array;

    public function getQueryOrderBy(): ?QueryOrderBy;

    public function getQueryPagination(): ?QueryPagination;

    public function getQuerySelect(): ?QuerySelect;

    public function getQueryWith(): ?QueryWith;

    public function getQueryCount(): int;
}