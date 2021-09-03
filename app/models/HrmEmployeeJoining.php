<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmEmployeeJoining extends Model
{
	protected $table 		= 'hrm_employee_joining';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
