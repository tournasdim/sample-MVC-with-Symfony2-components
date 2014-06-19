<?php
namespace controllers;

use models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class UserController extends BaseController 
{

    public function listallAction()
    {

        $users = User::all();
        $data = array('users' => $users->toArray());
        $flashMsg = $this->flashBag->getAll();

        if (!empty($flashMsg)) {
            switch (key($flashMsg)) {
            case 'info_msg':
                $data['info_msg'] = $flashMsg['info_msg'][0];
                break;
            case 'error_msg':
                $data['error_msg'] = $flashMsg['error_msg'][0];
                break;
            }
        }

        $data['csrf_token'] = $this->generateCsrfToken();
        return $this->render($data);

    }

    public function createAction()
    {

        if($this->requestObj->isMethod('GET')) {
            $data = array('info_msg' => 'Create a new user');
            $data['csrf_token'] = $this->generateCsrfToken();
            return $this->render($data); 
        }

        if (! $this->csrfHandler->isValidCsrf()) {
            $data = array('error_msg' => 'Cross-site request forgery attack detected , try again .....');
            $data['csrf_token'] = $this->generateCsrfToken();
            return $this->render($data);
        }

        $filteredFormData = $this->processForm($this->requestObj->request->all());

        if (!$filteredFormData) {
            $data = array('error_msg' => 'Submitted form had errors, try again.....');
            $data['csrf_token'] = $this->generateCsrfToken();
            return $this->render($data);           
        }

        User::create($filteredFormData);
        $this->flashBag->set('info_msg', 'A new user was created');
        return $response = new RedirectResponse($this->basepath.'/users');

    }

    public function editAction($id)
    {
 
        $user = User::find($id);
        $data = $user->toArray(); 
        $flashMsg = $this->flashBag->get('error_msg'); 

        if (!empty($flashMsg)) {
            $data['error_msg'] = $flashMsg[0];

        }

        $data['csrf_token'] = $this->generateCsrfToken();
        return $this->render($data);
        
    }

    public function updateAction($id)
    {

        if (! $this->csrfHandler->isValidCsrf()) {
            $this->flashBag->replace('error_msg','Cross-site request forgery attack detected , try again .....');
            return $response = new RedirectResponse($this->basepath."/users");
        }

        $filteredFormData = $this->processForm($this->requestObj->request->all());
        if (!$filteredFormData) {
            $this->flashBag->set('error_msg', 'Submitted data was not proper formated, try again'); 
            return $response = new RedirectResponse($this->basepath."/edit-user/$id");         
        }

        User::whereId($id)->update($filteredFormData) ;
        $this->flashBag->set('info_msg', 'User was updated'); 
        return $response = new RedirectResponse($this->basepath.'/users');
        
    } 

    public function deleteAction($id)
    {

        if (! $this->csrfHandler->isValidQuerystring()) {
        $this->flashBag->replace('error_msg', 'Cross-site request forgery attack detected , try again .....'); 
        } else {
        User::whereId($id)->delete();
        $this->flashBag->replace('info_msg', 'User was successfully deleted');     
        }
        return $response = new RedirectResponse($this->basepath.'/users');

    }

    private function processForm($formData)
    {

        unset($formData['csrf_token']);
        if (! $this->filterValidator->isValid($formData)) {
            // optionaly store violations into an array (not used in this project)
            $this->violations = $this->filterValidator->getViolations();
            return false ; 
        }
        return $filteredFormData = $this->filterValidator->filter($this->requestObj, $formData);
        
    }

    private function generateCsrfToken()
    {

        $csrfToken = $this->csrfHandler->generateCsrfToken();
        $this->flashBag->replace('csrf_token', $csrfToken);
        return $csrfToken;

    }
}