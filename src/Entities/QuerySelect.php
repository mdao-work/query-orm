<?php


namespace mdao\QueryBuilder\Entities;


use mdao\QueryBuilder\Contracts\Arrayable;

class QuerySelect implements Arrayable
{
    /**
     * 查询字段
     * @var array
     */
    protected $select = ['*'];

    public function __construct(array $select = ['*'])
    {
        $this->setSelect($select);
    }

    /**
     * @return array
     */
    public function getSelect(): array
    {
        return $this->select;
    }

    /**
     * @param array $select
     */
    public function setSelect(array $select): void
    {
        $this->select = $select;
    }

    /**
     * @return array
     */
    public function toArray():array
    {
        return $this->getSelect();
    }
}