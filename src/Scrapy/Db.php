<?php

namespace Scrapy;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Db {

	public $em = false;
	private $dirModels = ['models/'];
	private $isDev 	= true;

	public function __construct()
	{
		$config = [
			'driver'   => 'pdo_pgsql',
		    'user'     => 'postgres',
		    'password' => 'postgres',
		    'dbname'   => 'novolivro',
		];

		$setup = Setup::createAnnotationMetadataConfiguration($this->dirModels, $this->isDev);
		$this->em = EntityManager::create($config, $setup);
	}

}