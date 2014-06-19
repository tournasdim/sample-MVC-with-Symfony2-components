<?php
namespace services;

use Symfony\Component\HttpFoundation\Session\Session;

class FlashBagHandler 
{
	protected $session;

	public function __construct()
	{

 		$this->session = new Session();	

	}

	public function getSessionObj()
	{

		return $this->session;

	}

	public function set($storageKey, $msg)
	{

		//$this->session->start();
		$this->session->getFlashBag()->add($storageKey, $msg);

	}

	public function replace($storageKey, $msg)
	{

		$this->session->getFlashBag()->clear();
		$this->session->getFlashBag()->add($storageKey, $msg);

	}

	public function get($storageKey, $default = array())
	{

		//$this->session->start();
		return $this->session->getFlashBag()->get($storageKey, (array) $default); 

	}

	public function getAll()
	{

		return $this->session->getFlashBag()->all();

	}

	public function clear()
	{

		$this->session->getFlashBag()->clear();
		
	}
}