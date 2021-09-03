<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
	public $timestamps 		= false;
	protected $table 		= 'permission_role';
	protected $primaryKey	= 'id';
}
