<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmShiftRoleEmployee extends Model
{
   	protected $table 		= 'hrm_shift_role_employee';
	protected $primaryKey	= 'id';  
	public    $timestamps 	= false;
}
