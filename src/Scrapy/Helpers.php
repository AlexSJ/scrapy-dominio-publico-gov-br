<?php

namespace Scrapy;

class Helpers {

	public static function setTipoArquivo($str)
	{
		$arrTipoArquivo = explode(':', $str);
		switch (trim(strtolower($arrTipoArquivo[1]))) {
			case 'texto':
				return 1;
				break;
			case 'som':
				return 2;
				break;
			case 'imagem':
				return 3;
				break;
			case 'video':
				return 4;
				break;
			default:
				return 1;
				break;
		}
	}

	public static function setFormato($str)
	{
		$arrStr = explode(':', $str);
		return trim(str_replace(["\n", " ", "\r", "\t"], "", $arrStr[1]), "\xC2\xA0");
	}

	public static function setTamanho($str)
	{
		$arrStr = explode(':', $str);
		return trim(str_replace(["\n", " ", "\r", "\t"], "", $arrStr[1]), "\xC2\xA0");
	}

    public static function extractUrl($url, $param)
    {
        $extract = parse_url($url);
        parse_str($extract['query'], $return);
        return $return[$param];
    }

    public static function slugify($text)
    {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
    }

}
