<?php


namespace mdao\QueryBuilder\Entities;

use  mdao\QueryBuilder\Contracts\ParserEntityContract;

class ParserUrlEntity implements ParserEntityContract
{
    public function apply($url)
    {
        $result = parse_url($url);

        if (empty($result['query'])) {
            return [];
        }
        parse_str($result['query'], $result);
        return $result;
    }
}

