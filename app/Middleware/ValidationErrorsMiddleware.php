<?php


namespace App\Middleware;


class ValidationErrorsMiddleware extends Middleware
{
    
    public function __invoke($request, $response, $next)
    {
        //WE TAKE THE SESSION INFO AND ADD IT TO ALL OF THE VIEWS
        //THE addGlobal 2 params variable(key used in the views) and the value
        if(isset($_SESSION['formErrors']) && is_array($_SESSION['formErrors'])){
            $this->container->view->getEnvironment()->addGlobal('formErrors', $_SESSION['formErrors']);
            unset($_SESSION['formErrors']);
        }
        
        $response = $next($request,$response);
        return $response;
        
    }
    
    
}