<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmEmployeeInactive extends Model
{
	protected $table 		= 'hrm_employee_inactive';
	protected $primaryKey	= 'id';  
	public $timestamps 		= true;
}
