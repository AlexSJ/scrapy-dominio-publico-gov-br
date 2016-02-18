<?php

namespace Scrapy\controllers;

use Scrapy\Db;
use Scrapy\Helpers as Helper;
use Scrapy\models\Itens;
use Scrapy\models\Autores AS Autor;
use GuzzleHttp\Client as guzzle;

class itemController {

    private $param = [];
    private $baseUri = "http://www.dominiopublico.gov.br/pesquisa/DetalheObraForm.do";
    private $bodyContents = '';
    private $html = '';
    private $doctrine = false;

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

        $tipoArquivo = $xpath->query('//*[@class="label_p"]');
        $detalhes = $xpath->query('//*[@class="detalhe2"]');

        $this->doctrine = new Db();

        if (!is_null($detalhes)) {

            $itemObj = new Itens();
            $titulo = $detalhes->item(1)->textContent;
            $itemObj->titulo = $titulo;
            $itemObj->slug = Helper::slugify($titulo);

            $itemObj->tipoArquivo = Helper::setTipoArquivo($tipoArquivo->item(0)->textContent);
            $itemObj->formato = Helper::setFormato($tipoArquivo->item(1)->textContent);
            $itemObj->tamanho = Helper::setTamanho($tipoArquivo->item(2)->textContent);

            $itemObj->autor = $this->setAutor($detalhes->item(3)->textContent);

            $this->doctrine->em->persist($itemObj);
            $this->doctrine->em->flush();

            print_r($itemObj->autor);
            
        }
        exit;
    }

    private function setAutor($autor)
    {
        $autor = trim(str_replace(["\n", "\r", "\t"], "", trim($autor)), "\xC2\xA0");
        $autorObj = (object)$this->doctrine->em->getRepository('Scrapy\models\Autores')->findOneBy(['autor' => $autor]);
        if (!$autorObj->id) {
            $autorObj = new Autor();
            $autorObj->autor = $autor;
            $autorObj->slug = Helper::slugify($autor);
            $this->doctrine->em->persist($autorObj);
            $this->doctrine->em->flush();
        }
        return $autorObj;
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
