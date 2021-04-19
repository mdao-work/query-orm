<?php


namespace mdao\QueryBuilder\Entities;

use  mdao\QueryBuilder\Contracts\ParserEntityContract;

class ParserDataEntity implements ParserEntityContract
{
    /**
     * @param array $param
     * @return array
     */
    public function apply( $param)
    {
        return $param;
    }
}