<?php


namespace App\Mail;


class Message
{
	
	protected $mailer;
	
	/**
	 * Message constructor.
	 * @param $mailer
	 */
	public function __construct($mailer)
	{ 
		$this->mailer = $mailer; 
		
	}
	
	public function to($address)
	{
		$this->mailer->addAddress($address);
	}
	
	
	public function subject($subject)
	{
		$this->mailer->Subject = $subject;
	}
	
	
	public function body($body)
	{
		$this->mailer->Body = $body;
	}
	
	
	public function from($from) //IF YOU WANT TO US A DIFFERENT SENDER EMAIL ADDRESS
	{
		$this->mailer->From = $from;
	}
	
	
	public function fromName($fromName) // IF YOU WANT TO USE A DIFFERENT SENDER NAME IN MAILER CALL
	{
		$this->mailer->FromName = $fromName;
	}	
	
}