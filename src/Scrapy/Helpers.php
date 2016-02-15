<?php

namespace Scrapy;

class Helpers {

    public static function extractUrl($url, $param)
    {
        $extract = parse_url($url);
        parse_str($extract['query'], $return);
        return $return[$param];
    }

}
