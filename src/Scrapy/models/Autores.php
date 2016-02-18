<?php

namespace Scrapy\models;

/**
 * Itens
 *
 * @Entity
 * @Table(name="autores")
 */
class Autores {

	/**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @Column(type="text", name="aut_nome")
     */
    public $autor;

    /**
     * @Column(type="text", name="aut_slug")
     */
    public $slug;

}