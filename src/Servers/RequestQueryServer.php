<?php


namespace mdao\QueryBuilder\Servers;

use mdao\QueryBuilder\Contracts\OrmEntityContract;
use mdao\QueryBuilder\Contracts\QueryServerContract;
use mdao\QueryBuilder\Entities\OrmEntity;
use mdao\QueryBuilder\Entities\ParserDataEntity;
use mdao\QueryBuilder\Entities\ParserEntity;
use mdao\QueryBuilder\Entities\QueryFilter;
use mdao\QueryBuilder\Entities\QueryOrderBy;
use mdao\QueryBuilder\Entities\QueryPagination;
use mdao\QueryBuilder\Entities\QuerySelect;
use mdao\QueryBuilder\Exception\ParserException;
use mdao\QueryBuilder\Parser;


class RequestQueryServer implements QueryServerContract
{
    protected $ormEntity;

    public function __construct(OrmEntityContract $ormEntity)
    {
        $this->ormEntity = $ormEntity;
    }

    public function getQueryFilter(): array
    {
        if ($result = $this->ormEntity->getFilter()) {
            $parser = new Parser();
            $filter = $parser->where($result);
            $filters = [];
            foreach ($filter as $value) {
                list($field, $operator, $value) = $value;
                $filters[] = new QueryFilter($field, $operator, $value);
            }
            return $filters;
        }

        return [];
    }

    /**
     * @return QueryOrderBy|null
     * @throws ParserException
     */
    public function getQueryOrderBy(): ?QueryOrderBy
    {
        if ($result = $this->ormEntity->getOrder()) {
            $parser = new Parser();

            $parser->apply( new ParserDataEntity(), [
                $this->ormEntity->getOrderBy(),
                $this->ormEntity->getSortedBy(),
            ]);

        }

        return [];
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