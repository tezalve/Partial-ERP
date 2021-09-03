<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmEmployeeActivity extends Model
{
  	protected $table 		= 'hrm_employee_activity';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
