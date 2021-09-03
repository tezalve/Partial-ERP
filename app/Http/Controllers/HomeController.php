<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $query = DB::SELECT("SELECT id,title,link_address FROM hrm_favourite_link WHERE users_id = $user_id ");
        
        $probation_employee=DB::SELECT("SELECT count(a.id) as probation_employee
                                from  hrm_employee a 
                                JOIN hrm_employee_job_info b on a.id=b.hrm_employee_id AND  a.active_status=1 AND b.employee_activity=1 AND hrm_employment_status_id=1
                                Join hrm_location c On b.hrm_location_id=c.id 
                                JOIN user_location i ON b.hrm_location_id = i.hrm_location_id AND i.users_id = $user_id ");
                                      

        $dashboard_data=DB::SELECT("SELECT count(DISTINCT b.hrm_depertment_id) as department,count(a.id) as total_employee,count(DISTINCT b.hrm_location_id) as location
                                from  hrm_employee a 
                                JOIN hrm_employee_job_info b on a.id=b.hrm_employee_id AND  a.active_status=1 AND b.employee_activity=1 
                                Join hrm_location c On b.hrm_location_id=c.id 
                                JOIN user_location i ON b.hrm_location_id = i.hrm_location_id AND i.users_id = $user_id
                                ");
       
        return view('dashboard.dashboard')
               ->with('data',$query)
               ->with('probation_employee',$probation_employee)
               ->with('dashboard_data',$dashboard_data);
    }
}
