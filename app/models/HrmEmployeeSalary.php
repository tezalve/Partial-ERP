<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmEmployeeSalary extends Model
{
   	protected $table 		= 'hrm_employee_salary';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
