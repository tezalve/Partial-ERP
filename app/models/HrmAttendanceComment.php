<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmAttendanceComment extends Model
{
    Protected $table 		= 'hrm_attendance_comment';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
