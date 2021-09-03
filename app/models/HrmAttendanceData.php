<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmAttendanceData extends Model
{
    Protected $table 		= 'hrm_attendance_data';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
