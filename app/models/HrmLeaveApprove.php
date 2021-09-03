<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmLeaveApprove extends Model
{
    protected $table 		= 'hrm_leave_approve';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
