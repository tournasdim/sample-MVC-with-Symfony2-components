<?php
namespace services;

class TwigProvider 
{
	public static function init()
	{

		$loader = new \Twig_Loader_Filesystem(__DIR__.'/../views');
		$twig = new \Twig_Environment($loader, 
						array('cache' => __DIR__.'/../../cache'));
		return $twig; 
		
	}
}