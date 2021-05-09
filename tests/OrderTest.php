<?php

namespace mdao\QueryOrm\Test;

use mdao\QueryOrm\Exception\ParserException;
use \PHPUnit\Framework\TestCase;
use mdao\QueryOrm\Servers\QueryServer;
use mdao\QueryOrm\Entities\OrmEntity;

class OrderTest extends TestCase
{
    /**
     * @throws ParserException
     */
    public function testParserEmpty()
    {
        $queryServer = new QueryServer(OrmEntity::createEntity([]));
        $this->assertNull($queryServer->getQueryFilter());
    }

    /**
     * @throws ParserException
     */
    public function testParserDesc()
    {

        $url = "https://www.baidu.com?order_by=id&sorted_by=desc";
        //1.0 用parse_url解析URL
        $data = parse_url($url);
        parse_str($data['query'], $arrQuery);

        $queryServer = new QueryServer(OrmEntity::createEntity($arrQuery));

        //验证表达式
        $this->assertEquals([[
            'column' => 'id',
            'direction' => 'desc',
        ]], $queryServer->getQueryOrderBy()[0]->toArray());
    }

    /**
     * 字段
     * @throws ParserException
     */
    public function testParserNull()
    {
        $url = "https://www.baidu.com?order_by=id&sorted_by=desc";
        //1.0 用parse_url解析URL
        $data = parse_url($url);
        parse_str($data['query'], $arrQuery);

        $queryServer = new QueryServer(OrmEntity::createEntity($arrQuery));

        //验证表达式
        $this->assertEquals([[
            'column' => 'id',
            'direction' => 'desc',
        ]], $queryServer->getQueryOrderBy()[0]->toArray());

        //验证表达式
        $this->assertEquals(null, $queryServer->getQuerySelect());
    }

    /**
     * 值
     * @throws ParserException
     */
    public function testParserAlias()
    {
        $url = "https://www.baidu.com?select=id,date,content:text,aa:b";
        //1.0 用parse_url解析URL
        $data = parse_url($url);
        parse_str($data['query'], $arrQuery);

        $queryServer = new QueryServer(OrmEntity::createEntity($arrQuery));

        //验证表达式
        $this->assertEquals(['id', 'date', 'text', 'b'], $queryServer->getQuerySelect()->toArray());
        $this->assertEquals(['content' => 'text', 'aa' => 'b'], $queryServer->getQuerySelect()->getAlias());

    }

    /**
     * 值
     * @throws ParserException
     */
    public function testParserTrim()
    {
        $url = "https://www.baidu.com?select=,id,date,content:text,aa:b,";
        //1.0 用parse_url解析URL
        $data = parse_url($url);
        parse_str($data['query'], $arrQuery);

        $queryServer = new QueryServer(OrmEntity::createEntity($arrQuery));

        //验证表达式
        $this->assertEquals(['id', 'date', 'text', 'b'], $queryServer->getQuerySelect()->toArray());
        $this->assertEquals(['content' => 'text', 'aa' => 'b'], $queryServer->getQuerySelect()->getAlias());

    }

}