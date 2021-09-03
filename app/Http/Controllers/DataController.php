<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DataController extends Controller
{
    function generate_registration($table_name, $column_name){
		$search = DB::select("SELECT MAX($column_name) As invno FROM $table_name");
		
		foreach ($search as $key)
			$maxinvoiceno = $key->invno;

		$yearid 	= date("y");
		$monthid 	= date("m");
		$datevalue 	= $yearid . $monthid; 
		$invoice_no = substr($maxinvoiceno, 0,4);  
		
		if ($maxinvoiceno==0){
			$a = "0001";
			$new_invoice_no = $yearid . $monthid . $a;
		} else {
			if ($invoice_no==$datevalue){
				$maxinvoiceno = trim(substr($maxinvoiceno, 4)) + 1;
				$maxinvoiceno = sprintf("%04s", $maxinvoiceno);
				$new_invoice_no = $datevalue . $maxinvoiceno;
			} else {
				$a = "0001";
				$new_invoice_no = $yearid . $monthid . $a;              
			}
		}
		return $new_invoice_no;
	}
}
