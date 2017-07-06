<?php


namespace App\Middleware;


class FlashMessageMiddleware extends Middleware 
{
	public function __invoke($request, $response, $next){
		
		if(isset($_SESSION['slimFlash']) && is_array($_SESSION['slimFlash'])){
			
			$this->container->view->getEnvironment()->addGlobal('flash',$_SESSION['slimFlash']);
		}
		
		unset($_SESSION['slimFlash']);
		
		$response = $next($request, $response);
		
		return $response;
	}
	
}