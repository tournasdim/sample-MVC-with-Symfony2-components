<?php
namespace controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WelcomeController extends BaseController 
{

    public function homeAction()
    {

        return $this->render();

    }

    public function home2Action()
    {

        $data = array('name' => 'John Doe');
        //return $this->render($data, 'WelcomeController::homeAction'); // works : overwriting default template
        return $this->render($data);

    }
}