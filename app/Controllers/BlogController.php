<?php


namespace App\Controllers;

use Respect\Validation\Validator as v;
use App\Models\Blog as Blog;


class BlogController extends Controller{
	
	/**
	 * @param $request
	 * @param $response
	 *
	 * @return mixed
	 */
	public function viewBlog($request,$response)
	{
		
		$categories = $this->db->table('category')->select('id','name')->get();
		
		return $this->view->render($response,'blog.twig',array('categories'=>$categories));
	}
	
	/**
	 * @param $request
	 * @param $response
	 *
	 * @return mixed
	 */
	public function postBlog($request,$response)
	{
		$file = $request->getUploadedFiles();
		
		$validation = $this->validator->validate($request,array(
			'title'=> v::notEmpty(),
			'category'=> v::notEmpty(),
			'body'=>v::notEmpty(),
		));
		
		//CHECK VALIDATOR CONTROLLER FOR CODE
		$check_file = $this->validator->validateImage($file,array(
			'error' => v::equals(0),
			'type' => v::ImageCheck(),
			'filename' => v::notEmpty(),
		));
		
		if($validation->failed() || $check_file->failed()){
			return $response->withRedirect($this->router->pathFor('blog'));
		}
		
		$folder = 'images';
		
		//FROM CONFIG WORK FILE
		echo $directory = $this->config->get('folder.location');
		
		
		//IF FOLDER DOES NOT EXISTS
		if(!file_exists($folder))
			mkdir($directory.'/images');
		
		
		
		$test = $this->moveUploadedFile($directory.'/images',$file['image']);
		
		
		die($test);
		
		/*//FILE AND POST IS VALIDATED
		$blog = Blog::create(array(
			'title'       => 'Test',
			'body'        => 'Test',
			'image_path'  => 'path/path',
			'fk_category' => 1,
		));
		
		
		
		if($blog){
			echo 'true';
		}*/
		
		
		$categories = $this->db->table('category')->select('id','name')->get();
		
		return $this->view->render($response,'blog.twig',array('categories'=>$categories));
	}
	
	
	public function moveUploadedFile($directory, $uploadedFile)
	{
		
		
		
		$extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
		$basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
		$filename = sprintf('%s.%0.8s', $basename, $extension);
		
		$uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
		
		return $filename;
	}
	
}