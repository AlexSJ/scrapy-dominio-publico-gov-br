<?php
/*
rotas
	route.itens limit.100 start.0
		route => Controller a ser executado
		limit => quantidade de registros a ser buscado
		start => inicia a partir de qual registro

	route.item item.<integer>
		item => código da obra */

require_once 'vendor/autoload.php';

use Scrapy\router as route;
$params = route::setParams($argv);
route::add($params['route'], $params);
