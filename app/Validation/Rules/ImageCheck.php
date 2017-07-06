<?php


namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use Respect\Validation\Validator as v;

class ImageCheck extends AbstractRule
{
    public function validate($input)
    {
    	$check_passed = false;

    	$allowed_extentions = array(
			'jpeg',
			'jpg',
			'gif',
			'bmp',
			'png'
		);
	
		foreach($allowed_extentions as $allowed_extention){
			if(v::extension($allowed_extention)->validate($input))
				$check_passed = true;
    	}
    	
       //CHECK TO SEE IF THE FILE EXTENSION IS THERE
      return $check_passed;
       
    }
}