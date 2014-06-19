<?php
namespace controllers;

use services\DbProvider;
use services\CsrfHandler;
use services\TwigProvider;
use services\FilterValidator;
use services\FlashBagHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class BaseController
{
	protected $twig;
	protected $flashBag;
	protected $violations;
	protected $requestObj;
	protected $csrfHandler;
	protected $filterValidator;
	protected $basepath;

	public function __construct()
	{

		$this->init();

	}

	private function init()
	{

		DbProvider::init();
		$this->violations = array();
		$this->twig = TwigProvider::init();
		$this->flashBag = new FlashBagHandler();
		$this->filterValidator = new FilterValidator();
		$this->requestObj = Request::createFromGlobals();
		$this->csrfHandler = new CsrfHandler($this->requestObj, $this->flashBag);
		$this->basepath = $this->requestObj->getBasePath();


	}

	protected function render($data = array(),$tmpl = null)
	{

		if (null === $tmpl) {
			$backtrace = debug_backtrace(); 
			$template = $this->getTemplateName($backtrace) ; 
			$dir = $this->getControllerName($backtrace);
		} else {			
			list($dir, $template) = $this->explodeString($tmpl);
		}

		$content = $this->twig->render("{$dir}".'/'."{$template}.html.twig", 
								array('data' => $data));
		return new Response($content);

	}

	protected function getTemplateName($backtrace)
	{

		$methodName = substr($backtrace[1]['function'], 0, -6);
		return $methodName; 

	}

	protected function getControllerName($backtrace)
	{

		$canonical = $backtrace[1]['class'];
		$fullName = trim(strstr($canonical, '\\' ), '\\');
		$controllerName = substr($fullName, 0, -10);
		return lcfirst($controllerName);

	}

	protected function explodeString($tmpl)
	{

		list($controllerName, $actionName) = explode('::', $tmpl);
		$dir = substr($controllerName, 0, -10);
		$template = substr($actionName, 0, -6);
		return array(lcfirst($dir), $template);
		
	} 
}