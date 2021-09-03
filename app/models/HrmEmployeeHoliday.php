<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmEmployeeHoliday extends Model
{
	protected $table 		= 'hrm_employee_holiday';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
