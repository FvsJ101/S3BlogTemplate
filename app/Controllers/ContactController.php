<?php


namespace App\Controllers;

use Respect\Validation\Validator AS v;

class ContactController extends Controller
{
	public function getContact($request,$response)
	{
		return $this->view->render($response,'contact.twig');
	}
	
	public function postContact($request,$response)
	{
		
		//FORM VALIDATION
		$validation = $this->validator->validate($request,array(
			//KEY IS DEPENDED ON THE NAME VALUES FROM THE FORM
			'name'    => v::notEmpty()->alpha(),
			'phone'   => v::notEmpty()->phone(),
			'email'   => v::email()->noWhitespace()->notEmpty(),
			'message' => v::notEmpty()
		));
		
		if($validation->failed()){
			return $response->withRedirect($this->router->pathFor('contact'));
		}
		
		$mail_to = $request->getParam('email');
		$name = $request->getParam('name');
		$phone = $request->getParam('phone');
		$email = $request->getParam('email');
		$message = $request->getParam('message');
	
		
		//SENDS TO ME
		$this->mailer->send('email/contact.twig', array('name'=>$name,'phone'=>$phone,'email'=>$email,'message'=>$message), function ($message) use($mail_to) {
			$message->to($mail_to);
			$message->subject('New Contact Request');
			$message->from('No-Reply@frostweb.co.za');
			
		});
		
		$this->flash->addMessage('info','Your email request has been sent. Thank You.');
		
		//IF MESSAGES SENT BACK TO HOME
		return $response->withRedirect($this->router->pathFor('home'));
		
	}
}