<?php

namespace Scrapy\controllers;

use Scrapy\Helpers as Helper;
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

        $trs = $xpath->query('//*[@class="detalhe2"]');

        if (!is_null($trs)) {
            foreach ($trs as $tr) {
                $td = $tr->getElementsByTagName('td');
                $t = $td->item(0);
                var_dump($t);
                exit;
            }
        }
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
