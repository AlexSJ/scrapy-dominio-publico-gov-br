<?php

namespace Scrapy\controllers;

use Scrapy\Helpers as Helper;
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
                $td = $tr->getElementsByTagName('td');
                // Get item ID
                // The ID is in the URL (../pesquisa/DetalheObraForm.do?select_action=&co_obra=28320)
                $link = $td->item(2)->getElementsByTagName('a')->item(0)->getAttribute('href');
                $id = Helper::extractUrl($link, 'co_obra');

                exec("php5 -f index.php route.item item." . $id . " > log");
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
