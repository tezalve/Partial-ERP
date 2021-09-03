<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmLeaveYear extends Model
{
    protected $table 		= 'hrm_leave_years';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
