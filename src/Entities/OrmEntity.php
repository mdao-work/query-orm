<?php


namespace mdao\QueryBuilder\Entities;

class OrmEntity
{
    /**
     * @var array
     */
    protected $filter = [];
    /**
     * @var int
     */
    protected $orderBy;
    /**
     * @var int
     */
    protected $sortedBy;
    /**
     * @var int
     */
    protected $page;
    /**
     * @var int
     */
    protected $pageSize;

    /**
     * @var
     */
    protected $select = ['*'];

    /**
     * OrmEntity constructor.
     * @param array|null $filter
     * @param int|null $orderBy
     * @param int|null $sortedBy
     * @param int|null $page
     * @param int|null $pageSize
     * @param array|string[] $select
     */
    public function __construct(
        array $filter = null,
        int $orderBy = null,
        int $sortedBy = null,
        int $page = null,
        int $pageSize = null,
        array $select = ['*']
    )
    {
        $this->filter = $filter;
        $this->orderBy = $orderBy;
        $this->sortedBy = $sortedBy;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->select = $select;
    }


}