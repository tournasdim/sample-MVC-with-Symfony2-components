<?php
namespace services;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Database\Capsule\Manager as Capsule;

class DbProvider
{
	public static function init()
	{

		$config = Yaml::parse(file_get_contents(__DIR__.'/../config/db-config.yml'));
		$capsule = new Capsule;
		$capsule->addConnection($config['database']);
		$capsule->bootEloquent() ; 
		
	}
}