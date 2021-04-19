<?php


namespace mdao\QueryBuilder;

use mdao\QueryBuilder\Exception\ParserException;
use mdao\QueryBuilder\Entities\ParserEntity;
use mdao\QueryBuilder\Contracts\ParserEntityContract;

class Parser
{

    protected $filter = 'filter';
    protected $orderBy = 'order_by';
    protected $sortedBy = 'sorted_by';
    protected $page = 'page';
    protected $pageSize = 'page_size';
    protected $select = 'select';
    protected $param = 'select';

    public function __construct()
    {
    }

    /**
     * @param ParserEntityContract $parserEntityContract
     * @return ParserEntity
     * @throws ParserException
     */
    public function apply(ParserEntityContract $parserEntityContract, $param): ParserEntity
    {

        $params = $parserEntityContract->apply($param);

        $filter = $params[$this->filter] ?? [];

        $filter = $this->where($filter);
        $orderBy = $params[$this->orderBy] ?? 'id';
        $sortedBy = $params[$this->sortedBy] ?? 'desc';
        $order = [];
        if (!empty($orderBy)) {
            $order = $this->order($orderBy, $sortedBy);
        }

        $page = $params[$this->page] ?? 1;
        $pageSize = $params[$this->pageSize] ?? 15;

        $pagination = $this->pagination($page, $pageSize);

        $select = $params[$this->select] ?? '';

        $select = $this->select($select);

        return new ParserEntity($filter, $select, $order, $pagination);
    }

    /**
     * 解析字段
     * @param string $value
     * @return array|string[]
     */
    public function select(string $value): array
    {
        if (!stripos($value, ',')) {
            return [$value];
        }

        if ($values = explode(',', $value)) {
            return $values;
        }

        return [];
    }

    /**
     *filed[~] like
     *filed[in] in
     *field[!] !=
     *field[=] =
     *field[>] >
     *field[>=] >=
     *field[<] <
     *field[<=] <=
     *field[<>] BETWEEN
     *field[><] NOT BETWEEN
     * @param array $values
     * @return array
     */
    public function where(array $values): array
    {
        $where = [];
        $regexp = '/([a-zA-Z0-9_\.]+)(\[(?<operator>\>\=?|in?|\=?|\<\=?|\!|\<\>|\>\<|\!?~)\])?/i';
        foreach ($values as $field => $value) {
            preg_match($regexp, "[{$field}]", $match);
            $operator = $match['operator'] ?? '';
            $operator = $this->operator($operator);

            if (is_array($value) && $operator = '=') {
                $operator = 'in';
            }

            $where[] = [$match[1], $operator, $value];
        }
        return $where;
    }

    /**
     * @param string $value
     * @return string
     */
    public function operator(string $value): string
    {
        $operator = '';
        switch ($value) {
            case "in":
                $operator = 'in';
                break;
            case "~":
                $operator = 'like';
                break;
            case "!":
                $operator = '<>';
                break;
            case "<":
                $operator = '<';
                break;
            case "<=":
                $operator = '<=';
                break;
            case ">":
                $operator = '>';
                break;
            case ">=":
                $operator = '>=';
                break;
            case "<>":
                $operator = 'between';
                break;
            case "><":
                $operator = 'not between';
                break;
            case "=":
            default:
                $operator = '=';
                break;
        }

        return $operator;
    }

    /**
     * &page=1&page_size=15
     * @param int $page
     * @param int $pageSize
     * @return array|int[]
     */
    public function pagination(int $page, int $pageSize): array
    {
        return [$page, $pageSize];
    }

    /**
     * @param string $orderBy 字段
     * @param string $sortedBy asc|desc
     * @return array|string[]
     * @throws ParserException
     */
    public function order(string $orderBy, string $sortedBy): array
    {
        //$orderBy=filed adn ($orderBy='asc' or $orderBy='desc')
        if (!stripos($orderBy, ',') && !stripos($sortedBy, ',')) {
            return [[$orderBy, $sortedBy]];
        }

        //$orderBy=filed1,filed1 adn ($orderBy='asc' or $orderBy='desc')
        if (stripos($orderBy, ',') && !stripos($sortedBy, ',')) {
            $orderBys = explode(',', $orderBy);

            $results = [];
            foreach ($orderBys as $orderBy) {
                $results[] = [[$orderBy, $sortedBy]];
            }
            return $results;
        }

        //$orderBy=filed1,filed1 and （ $orderBy='asc,desc'）
        if (stripos($orderBy, ',') && stripos($sortedBy, ',')) {
            $orderBys = explode(',', $orderBy);
            $sortedBys = explode(',', $sortedBy);

            if (count($orderBys) != count($sortedBys)) {
                throw new ParserException('orderBy count != sortedBy count');
            }

            $result = array_combine($orderBys, $sortedBys);

            $results = [];
            foreach ($result as $index => $item) {
                $results[] = [$index, $item];
            }
            return $results;
        }

        throw new ParserException('error');
    }

}