<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmLoanApplication extends Model
{
    protected $table 		= 'hrm_loan_application';
	protected $primaryKey	= 'id';  
	public $timestamps 		= true;
}
