<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HrmUserLocation extends Model
{
    protected $table 		= 'user_location';
	protected $primaryKey	= 'id';  
	public $timestamps 		= false;
}
