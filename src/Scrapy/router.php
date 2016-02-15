<?php

namespace Scrapy;

class router {

    private $params = null;

    public static function add($controller, $params)
    {
        $obj = 'Scrapy\controllers\\' . $controller . 'Controller';
        new $obj($params);
    }

    public static function setParams($params)
    {
        $p = [];
        foreach ($params as $param) {
            $paramArr = explode('.', $param);
            $p[$paramArr[0]] = $paramArr[1];
        }
        return $p;
    }

}
