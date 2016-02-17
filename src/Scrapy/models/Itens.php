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

}