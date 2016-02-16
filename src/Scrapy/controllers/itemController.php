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
        setlocale(LC_ALL,'pt_BR.UTF8');
mb_internal_encoding('UTF8'); 
mb_regex_encoding('UTF8');
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

        if (!function_exists("htmlspecialchars_decode")) {
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT) {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}

        if (!is_null($tds)) {
            $td = $tds->item(1)->textContent;

            $titulo = mb_convert_encoding($td, "UTF-8", "HTML-ENTITIES");
            //echo html_entity_decode($titulo, ENT_COMPAT, 'UTF-8');
            echo iconv( 'UTF-8', 'ASCII//TRANSLIT', $titulo );
            /*
            foreach ($trs as $key => $tr) {
                if () {

                }
                $td = $tr->getElementsByTagName('td');
                $t = $td->item(0);
                var_dump($t);
                exit;
            }*/
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
