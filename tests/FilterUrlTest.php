<?php

namespace mdao\QueryOrm\Test;

use \PHPUnit\Framework\TestCase;
use mdao\QueryOrm\Servers\QueryServer;
use mdao\QueryOrm\Entities\OrmEntity;

class FilterUrlTest extends TestCase
{
    /**
     * @throws \mdao\QueryOrm\Exception\ParserException
     */
    public function testParserEmpty()
    {
        $url = http_build_query(['filter' => []]);

        $queryServer = new QueryServer(OrmEntity::createEntity($url));
        $this->assertNull($queryServer->getQueryFilter());
    }

    /**
     * 表达式
     * @throws \mdao\QueryOrm\Exception\ParserException
     */
    public function testParserExp()
    {

        $url = "https://www.baidu.com?filter[created_at_1{eq}]=1&filter[created_at_2{neq}]=2&filter[created_at_3{gt}]=3&filter[created_at_4{egt}]=4&filter[created_at_5{lt}]=5&filter[created_at_6{elt}]=6&filter[created_at_7{like}]=7&filter[created_at_8{in}]=8&filter[created_at_9{between}]=9&filter[created_at_10]=10";
        //1.0 用parse_url解析URL
        $data = parse_url($url);
        parse_str($data['query'], $arrQuery);

        $queryServer = new QueryServer(OrmEntity::createEntity($arrQuery));

        //验证表达式
        $this->assertEquals('=', $queryServer->getQueryFilter()[0]->toArray()[1]);
        $this->assertEquals('<>', $queryServer->getQueryFilter()[1]->toArray()[1]);
        $this->assertEquals('>', $queryServer->getQueryFilter()[2]->toArray()[1]);
        $this->assertEquals('>=', $queryServer->getQueryFilter()[3]->toArray()[1]);
        $this->assertEquals('<', $queryServer->getQueryFilter()[4]->toArray()[1]);
        $this->assertEquals('<=', $queryServer->getQueryFilter()[5]->toArray()[1]);
        $this->assertEquals('like', $queryServer->getQueryFilter()[6]->toArray()[1]);
        $this->assertEquals('in', $queryServer->getQueryFilter()[7]->toArray()[1]);
        $this->assertEquals('between', $queryServer->getQueryFilter()[8]->toArray()[1]);
        $this->assertEquals('=', $queryServer->getQueryFilter()[9]->toArray()[1]);
    }

    /**
     * in表达式
     * @throws \mdao\QueryOrm\Exception\ParserException
     */
    public function testParserInExp()
    {

        $url = "https://www.baidu.com?filter[created_at_1]=[1,2,3]&filter[created_at_2]=2,3,4&filter[created_at_3{in}]=3&filter[created_at_4{in}]=2,3,4&filter[created_at_5{in}]=[1,2,3]";
        //1.0 用parse_url解析URL
        $data = parse_url($url);
        parse_str($data['query'], $arrQuery);

        $queryServer = new QueryServer(OrmEntity::createEntity($arrQuery));

        //验证字段
        $this->assertEquals('created_at_1', $queryServer->getQueryFilter()[0]->toArray()[0]);
        $this->assertEquals('created_at_2', $queryServer->getQueryFilter()[1]->toArray()[0]);
        $this->assertEquals('created_at_3', $queryServer->getQueryFilter()[2]->toArray()[0]);
        $this->assertEquals('created_at_4', $queryServer->getQueryFilter()[3]->toArray()[0]);
        $this->assertEquals('created_at_5', $queryServer->getQueryFilter()[4]->toArray()[0]);

        //验证表达式
        $this->assertEquals('in', $queryServer->getQueryFilter()[0]->toArray()[1]);
        $this->assertEquals('=', $queryServer->getQueryFilter()[1]->toArray()[1]);
        $this->assertEquals('in', $queryServer->getQueryFilter()[2]->toArray()[1]);
        $this->assertEquals('in', $queryServer->getQueryFilter()[3]->toArray()[1]);
        $this->assertEquals('in', $queryServer->getQueryFilter()[4]->toArray()[1]);

        //验证值
        $this->assertEquals('1,2,3', $queryServer->getQueryFilter()[0]->toArray()[2]);
        $this->assertEquals('2,3,4', $queryServer->getQueryFilter()[1]->toArray()[2]);
        $this->assertEquals('3', $queryServer->getQueryFilter()[2]->toArray()[2]);
        $this->assertEquals('2,3,4', $queryServer->getQueryFilter()[3]->toArray()[2]);
        $this->assertEquals('1,2,3', $queryServer->getQueryFilter()[4]->toArray()[2]);

    }

    /**
     * 字段
     * @throws \mdao\QueryOrm\Exception\ParserException
     */
    public function testParserField()
    {
        $url = "https://www.baidu.com?created_at_1[eq]=1&created_at_2[neq]=2&created_at_3[gt]=3&created_at_4[egt]=4&created_at_5[lt]=5&created_at_6[elt]=6&created_at_7[like]=7&created_at_8[in]=8&created_at_9[between]=9&created_at_10=10";
        //1.0 用parse_url解析URL
        $data = parse_url($url);

        //2.0 将URL中的参数取出来放到数组里
        $arrQuery = $this->convertUrlQuery($data['query']);

        $queryServer = new QueryServer(OrmEntity::createEntity(['filter' => $arrQuery]));

        //验证表达式
        $this->assertEquals('created_at_1', $queryServer->getQueryFilter()[0]->toArray()[0]);
        $this->assertEquals('created_at_2', $queryServer->getQueryFilter()[1]->toArray()[0]);
        $this->assertEquals('created_at_3', $queryServer->getQueryFilter()[2]->toArray()[0]);
        $this->assertEquals('created_at_4', $queryServer->getQueryFilter()[3]->toArray()[0]);
        $this->assertEquals('created_at_5', $queryServer->getQueryFilter()[4]->toArray()[0]);
        $this->assertEquals('created_at_6', $queryServer->getQueryFilter()[5]->toArray()[0]);
        $this->assertEquals('created_at_7', $queryServer->getQueryFilter()[6]->toArray()[0]);
        $this->assertEquals('created_at_8', $queryServer->getQueryFilter()[7]->toArray()[0]);
        $this->assertEquals('created_at_9', $queryServer->getQueryFilter()[8]->toArray()[0]);
        $this->assertEquals('created_at_10', $queryServer->getQueryFilter()[9]->toArray()[0]);
    }

    /**
     * 值
     * @throws \mdao\QueryOrm\Exception\ParserException
     */
    public function testParserValue()
    {
        $url = "https://www.baidu.com?filter[created_at_1{eq}]=1&filter[created_at_2{neq}]=2&filter[created_at_3{gt}]=3&filter[created_at_4{egt}]=4&filter[created_at_5{lt}]=5&filter[created_at_6{elt}]=6&filter[created_at_7{like}]=7&filter[created_at_8{in}]=8,9&filter[created_at_9{between}]=9,10&filter[created_at_10]=10";
        //1.0 用parse_url解析URL
        $data = parse_url($url);
        parse_str($data['query'], $arrQuery);

        $queryServer = new QueryServer(OrmEntity::createEntity($arrQuery));
        //验证表达式
        $this->assertEquals('1', $queryServer->getQueryFilter()[0]->toArray()[2]);
        $this->assertEquals('2', $queryServer->getQueryFilter()[1]->toArray()[2]);
        $this->assertEquals('3', $queryServer->getQueryFilter()[2]->toArray()[2]);
        $this->assertEquals('4', $queryServer->getQueryFilter()[3]->toArray()[2]);
        $this->assertEquals('5', $queryServer->getQueryFilter()[4]->toArray()[2]);
        $this->assertEquals('6', $queryServer->getQueryFilter()[5]->toArray()[2]);
        $this->assertEquals('7', $queryServer->getQueryFilter()[6]->toArray()[2]);
        $this->assertEquals('8,9', $queryServer->getQueryFilter()[7]->toArray()[2]);
        $this->assertEquals('9,10', $queryServer->getQueryFilter()[8]->toArray()[2]);
        $this->assertEquals('10', $queryServer->getQueryFilter()[9]->toArray()[2]);

    }

    /**
     * Returns the url query as associative array
     *
     * @param string    query
     * @return    array    params
     */
    private function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }

        return $params;
    }

    private function getUrlQuery($array_query)
    {
        $tmp = array();
        foreach ($array_query as $k => $param) {
            $tmp[] = $k . '=' . $param;
        }
        $params = implode('&', $tmp);
        return $params;
    }

    /**
     * 字符串、数组转换为格式化的数组
     * @param string $data 原始字符串
     * @return array
     */
    private function stringArrayConvertToArray(string $data): array
    {
        // 数组原样返回
        if (is_array($data)) {
            return $data;
        }
        $result = [];
        // 字符串处理
        $string = (string)$data;
        if (!empty($string) && preg_match('/^\[.*?]$/', $string)) {
            $result = json_decode($string, true);
        }

        if (!is_array($result) || count($result) < 1) {
            return [];
        }
        return $result;
    }
}