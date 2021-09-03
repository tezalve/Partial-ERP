<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
	protected $table 		= 'permissions';
	protected $primaryKey	= 'id';  
}
