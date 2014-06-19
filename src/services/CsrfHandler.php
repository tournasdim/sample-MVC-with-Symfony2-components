<?php
namespace services;

use Symfony\Component\Yaml\Yaml;

class CsrfHandler
{

	protected $security;
	protected $requestObj;
	protected $flashBag;

	public function __construct($requestObj, $flashBag)
	{

		$config = Yaml::parse(file_get_contents(__DIR__.'/../config/csrf-token.yml'));
		$security = $config['security-token'];
		$this->security = $security;
		$this->flashBag = $flashBag;
		$this->requestObj = $requestObj;

	}

	public function isValidCsrf()
    {
       
        $flashBagCsrfToken = $this->flashBag->get('csrf_token');
        $formCsrfToken = $this->requestObj->request->get('csrf_token');
        return $equal = ($flashBagCsrfToken[0] === $formCsrfToken) ? true : false ; 

        
    }

    public function isValidQuerystring()
    {

        $securityToken = $this->flashBag->get('csrf_token');
        $queryString = $this->requestObj->getQueryString();
        return $equal = ($securityToken[0] == $queryString) ? true : false ; 

    }

    public function generateCsrfToken()
    {
        
        $intention = uniqid('_auth',true);
        return sha1($this->security.$intention);

    }
}
