<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmPayRegister extends Model
{
	public $timestamps 		= false;
    protected $table 		= 'pay_register';
	protected $primaryKey	= 'id';  
}
