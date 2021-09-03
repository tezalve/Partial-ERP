<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmLoanLedger extends Model
{
    protected $table 		= 'hrm_loan_ledger';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
