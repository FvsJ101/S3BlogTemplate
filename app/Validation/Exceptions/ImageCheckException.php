<?php


namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;


class ImageCheckException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => '{{name}} is not an image',
        ),
       
    );
    
        
}