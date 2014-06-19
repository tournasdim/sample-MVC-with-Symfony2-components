<?php 
namespace models;

use Illuminate\Database\Eloquent\Model as Eloquent;


class User extends Eloquent 
{
	protected $table = 'users';
	protected $fillable = array('name', 'country', 'email');

	
}