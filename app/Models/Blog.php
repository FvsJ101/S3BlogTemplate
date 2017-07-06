<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //TO TELL ELOQUENT TO USE WHAT TABLE
	/**
	 * @var string
	 */
	protected $table  = "blog";
	
	/**
	 * @var array
	 */
	protected $fillable = array(
        // list fields that can be edited
        'title',
        'image_path',
        'last_name',
        'body',
        'fk_category'
    );
}