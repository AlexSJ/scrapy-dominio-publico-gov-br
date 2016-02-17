<?php

namespace Scrapy\controllers;

use Scrapy\Db;
use Scrapy\Helpers as Helper;
use Scrapy\models\Itens;
use GuzzleHttp\Client as guzzle;

class itemController {

    private $param = [];
    private $baseUri = "http://www.dominiopublico.gov.br/pesquisa/DetalheObraForm.do";
    private $bodyContents = '';
    private $html = '';

    public function __construct($params)
    {
        $this->param = $params;
        $this->getHTML();
        $this->getItem();
    }

    private function getItem()
    {
        libxml_use_internal_errors(true);

        $doc = new \DOMDocument();
        $doc->loadHTML($this->bodyContents);

        $xpath = new \DOMXpath($doc);

        $tds = $xpath->query('//*[@class="detalhe2"]');

        $doctrine = new Db();

        if (!is_null($tds)) {
            $titulo = $tds->item(1)->textContent;

            $itemObj = new Itens();
            $itemObj->titulo = $titulo;

            $doctrine->em->persist($itemObj);
            $doctrine->em->flush();

            echo $itemObj->id;
            
        }
        exit;
    }

    private function getHTML()
    {
        $client = new guzzle();
        $request = $client->request('GET', $this->baseUri, ['query' => 'select_action=&co_obra=' . $this->param['item']]);
        $this->html = $request->getBody();
        $this->bodyContents = $this->html->getContents();
        return;
    }

}
