<?php

namespace Scrapy;

class router {

    public static function add($controller, $params)
    {
        $options = self::setParams($params);
        $obj = 'Scrapy\controllers\\' . $controller . 'Controller';
        new $obj($options);
    }

    private static function setParams($params)
    {
        $p = [];
        foreach ($params as $param) {
            $paramArr = explode('.', $param);
            $p[$paramArr[0]] = $paramArr[1];
        }
        return $p;
    }

}
