<?php
session_start();
require __DIR__."/../vendor/autoload.php";
define('INC_ROOT', dirname(__DIR__));

use App\Mail\Mailer AS Mailer;
use App\Validation\Validator AS Validator;
use App\Middleware\ValidationErrorsMiddleware AS ValidationErrors;
use Slim\Flash\Messages AS Flash;
use App\Middleware\FlashMessageMiddleware AS FlashMessage;
use Noodlehaus\Config AS Config;
use Respect\Validation\Validator as v;

//SETTINGS
$app = new Slim\App(array(
		'settings' => array(
			'displayErrorDetails'               => true, //CHANGE THIS WHEN GO LIVE
			'determineRouteBeforeAppMiddleware' => true,
			'mode'                              => 'work'
		)
));

//CONTAINER
$container = $app->getContainer();

/*
TO GET ITEMS OUT OF THE CONFIG FILE
//echo $container['config']->get('app.url');
*/
$container['config'] = function($container){
	$Config = new Config(INC_ROOT."/app/Config/".$container->get('settings')['mode'].".php");
	
	return $Config;
};


//DATABASE SETUP
require INC_ROOT."/app/DB/database.php";
$container['db'] = function($container) use ($capsule){
	return $capsule;
};

//ATTACH TWIG VIEWS
$container['view'] = function ($container){
	$view = new \Slim\Views\Twig(
				__DIR__.'/../resources/views',array(
					'cache' => false
				)
	);
	
	$view->addExtension(new Slim\Views\TwigExtension(
			$container->router,
			$container->request->getUri()
	));
	return $view;
};

//MAILER
$container['mailer'] = function ($container) {
	
	$mailer = new PHPMailer;
	
	$mailer->Host           = "smtp.frostweb.co.za";
	$mailer->SMTPAuth       = true;
	$mailer->SMTPSecure     = "tls";
	$mailer->Port           = 587;
	$mailer->Username       = "no-reply@frostweb.co.za";
	$mailer->Password       = "N0-R3ply2016";
	
	$mailer->isHTML(true);
	$mailer->SetFrom("No-Reply@frostweb.co.za","No-Reply");
	
	return new Mailer($container->view, $mailer);
};







/*===================================== CONTROLLERS ==========================================*/
//ATTACHE HOME CONTROLLER
$container['HomeController'] = function ($container){
	return new App\Controllers\HomeController($container);
};

//ATTACHE CONTACT CONTROLLER
$container['ContactController'] = function ($container){
	return new App\Controllers\ContactController($container);
};

//ATTACHE BLOG CONTROLLER
$container['BlogController'] = function ($container){
	return new App\Controllers\BlogController($container);
};

//VALIDATOR
$container['validator'] = function ($container) {
	return new Validator($container);
};

//FLASH MESSAGE SECTION
$container['flash'] = function ($container){
	return new Flash($container);
};

//////////MIDDLEWARE SECTION/////////////////
v::with('App\\Validation\\Rules\\'); //ALLOW THE VALIDATION LIBRARY TO USE CUSTOM RULES

//VALIDATION OF ERRORS
$app->add(new ValidationErrors($container));

//FLASH MESSAGE
$app->add(new FlashMessage($container));


//////////ROUTS SECTION/////////////////
require __DIR__."/../app/routes.php";