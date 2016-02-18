<?php

namespace Scrapy\models;

/**
 * Itens
 *
 * @Entity
 * @Table(name="itens")
 */
class Itens {

	/**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @Column(type="text", name="ite_titulo")
     */
    public $titulo;

    /**
     * @Column(type="text", name="ite_slug")
     */
    public $slug;

    /**
     * @Column(type="string", name="ite_tamanho")
     */
    public $tamanho;

    /**
     * @Column(type="string", name="ite_formato")
     */
    public $formato;

    /**
     * @Column(type="string", name="ite_tipo_arquivo")
     */
    public $tipoArquivo;

    /**
     * @ManyToOne(targetEntity="Scrapy\models\Autores")
     * @JoinColumn(name="ite_id_autor", referencedColumnName="id")
     */
    public $autor;

}