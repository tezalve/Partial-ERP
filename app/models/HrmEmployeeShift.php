<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmEmployeeShift extends Model
{
	protected $table 		= 'hrm_employee_shift';
	protected $primaryKey	= 'id';  
	public $timestamps 		= true;
}
