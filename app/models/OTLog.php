<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class OTLog extends Model
{
    protected $table 		= 'log_ot';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
