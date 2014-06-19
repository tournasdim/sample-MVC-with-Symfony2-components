<?php
namespace services;

use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\Validator\Constraint; 
use Symfony\Component\Validator\Validation;

class FilterValidator 
{

	protected $constraints;
	protected $violations;

	public function __construct()
	{

		$this->init();
		
	}

	public function isValid($formData)
	{

		$validator = Validation::createValidator();
	    $violations = $validator->validateValue($formData, $this->constraints, 
	    				array(Constraint::DEFAULT_GROUP)); 

	    if ($violations->count() > 0) {
	        foreach ($violations as $val) {
	        	$this->violations[] = $val->getMessage() ; 
	        }
        return false;
	    }

	    return true;
	}

	public function filter($requestObj, $formData)
	{

		$filtered = array();
		foreach ($formData as $k => $v) {
			if ($k === 'email') {
			$filtered[$k] = $requestObj->request->filter($k, null, false, FILTER_SANITIZE_EMAIL);	
			continue;
			}
		$filtered[$k] = $requestObj->request->filter($k, null, false, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		}
		return $filtered;

	}

	public function getViolations()
	{

		return $this->violations;

	}

	protected function init()
	{
   
		$constraints = new Assert\Collection(array(
                            'country' => array(
                                        new Assert\NotBlank(),
                                        new Assert\Length(array('min' => 2, 'max' => 50)),
                                            ),
                            'name' => array(
                                        new Assert\NotBlank(), 
                                        new Assert\Length(array('min' => 5, 'max' => 50),
                                        new Assert\NotEqualTo(['value' => ['admin']]))
                                            ),
                            'email' => array(
                                        new Assert\NotBlank(), 
                                        new Assert\Length(array('min' => 8, 'max' => 50)),
                                        new Assert\Email(),
                                            ),                           
                            ));
		$this->constraints =  $constraints;
		$this->violations = array();

	}
}