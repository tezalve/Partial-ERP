<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmAttendance extends Model
{
  	protected $table 		= 'hrm_attendance_raw_data';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
