<?php 

use Symfony\Component\Routing\Route;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


require dirname(__DIR__).'/vendor/autoload.php';
$routes = new RouteCollection();
require dirname(__DIR__).'/src/routeClosures.php';

/* Reading Yaml for routes and creating a RouteCollection object */
$loader = new YamlFileLoader(new FileLocator(dirname(__DIR__).'/src/config'));
$collection = $loader->load('routes.yml');
$routes->addCollection($collection);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener(new UrlMatcher($routes , new RequestContext())));
$kernel = new HttpKernel($dispatcher, new ControllerResolver());
$request = Request::createFromGlobals();

	try
	{
		$response = $kernel->handle($request);
		$response->send();
	}
	catch (NotFoundHttpException $e)
	{

	  echo $e->getMessage(); 
	}
