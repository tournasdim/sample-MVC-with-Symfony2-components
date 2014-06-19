<?php

use Symfony\Component\Routing\Route; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$routes->add('foo' , new Route('/foo' , [
	'_controller' => function (Request $request) {
		return new Response('foo!!!!');
	}]));

$routes->add('hello' , new Route('/hello/{name}' , [ 
	'_controller' => function (Request $request , $name ) {
		return new Response('Hello'. $name); 
	}])); 