<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmLeaveLedger extends Model
{
	protected $table 		= 'hrm_leave_ledger';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
