<?php

namespace Scrapy\controllers;

use GuzzleHttp\Client as guzzle;

class itensController {

    private $param = [];
    private $baseUri = "http://www.dominiopublico.gov.br/pesquisa/ResultadoPesquisaObraForm.do";
    private $bodyContents = '';
    private $html = '';

    public function __construct($params)
    {
        $this->param = $params;
        $this->getHTML();
        $this->getItens();
    }

    private function getItens()
    {
        libxml_use_internal_errors(true);

        $doc = new \DOMDocument();
        $doc->loadHTML($this->bodyContents);

        $xpath = new \DOMXpath($doc);

        $trs = $xpath->query('//*[@id="res"]/tbody/tr');

        if (!is_null($trs)) {
            foreach ($trs as $tr) {
                var_dump($tr);
                exit;
            }
        }
    }

    private function getHTML()
    {
        $client = new guzzle();
        $request = $client->request('GET', $this->baseUri, ['query' => 'first=' . $this->param["limit"] . '&skip=' . $this->param["start"] . '&ds_titulo=&co_autor=&no_autor=&co_categoria=&pagina=2&select_action=Submit&co_midia=2&co_obra=&co_idioma=&colunaOrdenar=null&ordem=null']);
        $this->html = $request->getBody();
        $this->bodyContents = $this->html->getContents();
        return;
    }

}
