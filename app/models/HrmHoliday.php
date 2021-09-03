<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmHoliday extends Model
{
	protected $table 		= 'hrm_holiday';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
