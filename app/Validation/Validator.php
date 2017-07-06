<?php


namespace App\Validation;

use Respect\Validation\Validator AS Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;
    
    public function validate ($request, array $rules)
    {
        foreach($rules as $field=> $rule){
    
            try{
                $rule->setName(ucwords(str_replace("_"," ",$field)))->assert($request->getParam($field));
            }catch(NestedValidationException $e){
                $this->errors[$field] = $e->getMessages();
            }
        }
        
        //TAKE THE ERRORS AND THEN SAVE IT IN A SESSION WHERE WE CAN GET IT IN THE MIDDLEWARE VALIDATION ERRORS MIDDLEWARE
        $_SESSION['formErrors'] = $this->errors;
        
        return $this;
    }
	
	public function validateImage ($file,array $rules)
	{
		
		$check_info = array();
		$check_info['size'] = $file['image']->getSize();
		$check_info['error'] = $file['image']->getError();
		$check_info['filename'] = $file['image']->getClientFilename();
		$check_info['type'] = $file['image']->getClientFilename();
		
		foreach($rules as $field=> $rule){
			try{
				$rule->setName(ucwords(str_replace("_"," ",$field)))->assert($check_info[$field]);
				
			}catch(NestedValidationException $e){
				$this->errors[$field] = $e->getMessages();
			}
		}
		
		$_SESSION['formErrors'] = $this->errors;

		return $this;
		
	}
    
    public function failed()
    {
        return !empty($this->errors);
    }
    
}