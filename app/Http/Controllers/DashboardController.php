<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect;
use Auth;
use DB;
use Datatables;
use Crypt;
use Validator;
use Config;
use Session;
use Response;
use DateTime;


use App\models\HrmDepertment;
use App\models\HrmProbationPeriod;
use App\models\HrmEmployeeProbation;
use App\models\HrmEmployeeJobInfo;
use App\models\HrmEmployeeJoining;
use App\models\HrmEmployeeCardCode;
use App\models\HrmEmployeeShift;
use App\models\HrmEmployeeSalary;
use App\models\HrmEmployeeSalaryDetails;
use App\models\HrmEmployeeActivity;
use App\models\HrmFringeBenefitsConfig;


class DashboardController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
        // return view('depertment.depertment_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('depertment.create_depertment');
    }


    public function depertmentlist(Request $request){
        
        // return json_encode(array('data' => HrmDepertment::where('valid',1)->get()));        
    }




   public function provision_employeelist(){
    
        $user_id=Auth::user()->id;
     

        $currentemployee = DB::select("SELECT 
                                            a.id,
                                            CONCAT(a.employee_name, ' | ', b.employee_code) AS employee_name,
                                            c.location_name,
                                            d.depertment_name,
                                            e.alis AS designation_name,
                                            a.contact_number,
                                            f.joining_date,
                                            a.Images,
                                            b.id AS hrm_employee_job_info_id,
                                            DATE_ADD(f.joining_date,
                                                INTERVAL h.period MONTH) AS probable_date
                                        FROM
                                            hrm_employee a
                                                JOIN
                                            hrm_employee_job_info b ON a.id = b.hrm_employee_id
                                                AND a.active_status = 1
                                                AND b.employee_activity = 1
                                                AND hrm_employment_status_id = 1
                                                JOIN
                                            hrm_location c ON b.hrm_location_id = c.id
                                                JOIN
                                            hrm_depertment d ON b.hrm_depertment_id = d.id
                                                JOIN
                                            hrm_designation e ON b.hrm_designation_id = e.id
                                                JOIN
                                            hrm_employee_joining f ON b.hrm_employee_id = f.hrm_employee_id
                                                JOIN
                                            hrm_employee_probation g ON g.hrm_employee_id = a.id
                                                JOIN
                                            hrm_probation_period h ON h.id = g.hrm_probation_period_id
                                                JOIN
                                            user_location i ON b.hrm_location_id = i.hrm_location_id
                                                AND i.users_id = $user_id
                                                AND DATE_ADD(DATE_ADD(f.joining_date,
                                                    INTERVAL h.period MONTH),
                                                INTERVAL - 5 DAY) < CURRENT_DATE") ;
// and g.default_location=1


        return json_encode(array('data' => $currentemployee));                

    }



  public function departmentwise_present(){
    
            $user_id=Auth::user()->id;
                     

            $currentemployee = DB::select("SELECT aa.location_name,aa.depertment_name,Sum(Total_Employee) As total_employee,Sum(Present) As Present,Sum(Absent) As Absent,Sum(Leave_s) As Leave_s
            FROM
                (SELECT
                    e.location_name,
                    c.depertment_name,
                    COUNT(a.hrm_employee_id) AS Total_Employee,
                    0 AS Present,
                    0 As Absent,
                    0 As Leave_s

                FROM
                    hrm_attendance a
                        JOIN
                    hrm_employee_job_info b ON a.hrm_employee_id = b.hrm_employee_id
                        JOIN
                    hrm_depertment c ON b.hrm_depertment_id = c.id
                        JOIN
                    hrm_designation d ON b.hrm_designation_id = d.id
                        JOIN 
                    hrm_location e ON e.id=b.hrm_location_id
                    WHERE b.employee_activity=1
                    AND (a.punche_date) = '2018-07-25'
                GROUP BY e.location_name,c.depertment_name
                UNION
                SELECT
                    e.location_name,
                    c.depertment_name,
                    0 AS Total_Employee,
                    COUNT(a.hrm_employee_id) AS Present,
                    0 As Absent,
                    0 As Leave_s
                FROM
                    hrm_attendance a
                        JOIN
                    hrm_employee_job_info b ON a.hrm_employee_id = b.hrm_employee_id
                        AND a.attendance_status IN (2 , 5, 6)
                        JOIN
                    hrm_depertment c ON b.hrm_depertment_id = c.id
                        JOIN
                    hrm_designation d ON b.hrm_designation_id = d.id
                        JOIN 
                    hrm_location e ON e.id=b.hrm_location_id
                    WHERE b.employee_activity=1
                    AND (a.punche_date) = '2018-07-25'
                GROUP BY  e.location_name,
                    c.depertment_name
                UNION
                SELECT
                    e.location_name,
                    c.depertment_name,
                    0 AS Total_Employee,
                    0 As Present,
                    COUNT(a.hrm_employee_id) AS Absent,
                    0 As Leave_s
                FROM
                    hrm_attendance a
                        JOIN
                    hrm_employee_job_info b ON a.hrm_employee_id = b.hrm_employee_id
                        AND a.attendance_status IN (1)
                        JOIN
                    hrm_depertment c ON b.hrm_depertment_id = c.id
                        JOIN
                    hrm_designation d ON b.hrm_designation_id = d.id
                        JOIN 
                    hrm_location e ON e.id=b.hrm_location_id
                    WHERE b.employee_activity=1
                     AND (a.punche_date) = '2018-07-25'
                GROUP BY  e.location_name,
                    c.depertment_name
                UNION
                SELECT
                    e.location_name,
                    c.depertment_name,
                    0 AS Total_Employee,
                    0 As Present,
                    0 As Absent,
                    COUNT(a.hrm_employee_id) AS Leave_s

                FROM
                    hrm_attendance a
                        JOIN
                    hrm_employee_job_info b ON a.hrm_employee_id = b.hrm_employee_id
                        AND a.attendance_status IN (3,4)
                        JOIN
                    hrm_depertment c ON b.hrm_depertment_id = c.id
                        JOIN
                    hrm_designation d ON b.hrm_designation_id = d.id
                        JOIN 
                    hrm_location e ON e.id=b.hrm_location_id
                    WHERE b.employee_activity=1
                    AND (a.punche_date) = '2018-07-25'
                GROUP BY  e.location_name,
                    c.depertment_name
                ) aa

                GROUP BY aa.depertment_name,aa.location_name") ;

        return json_encode(array('data' => $currentemployee));                

    }



    public function probation_confirm(Request $request)
    {


        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'employee_id'       => 'required',
            'new_salary'        => 'required',
            'salary_grade'      => 'required',
            'confirmation_date' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $jobid = $request->hrm_employee_job_info_id;
        $confirmation_date    = date('Y-m-d', strtotime(str_replace('/', '-', $request->confirmation_date)));

        $xmasDay              = new DateTime($confirmation_date.'- 1 day');
        $end_date             = $xmasDay->format('Y-m-d');  
        $user_id = Auth::user()->id;
        $ldate   = date('Y-m-d H:i:s');


        $check_datas = DB::select("SELECT start_date FROM hrm_employee_activity  WHERE hrm_employee_job_info_id in (SELECT id FROM hrm_employee_job_info WHERE hrm_employee_id = $request->employee_id) AND start_date='$confirmation_date' ");


        if(!empty($check_datas)){
             $request->session()->flash('alert-danger', 'Sorry This date has been already used, Please Check!');        
             return Redirect::to('/'); 

                           
        }

        $check_data = DB::select("SELECT start_date FROM hrm_employee_activity  WHERE hrm_employee_job_info_id in (SELECT id FROM hrm_employee_job_info WHERE hrm_employee_id = $request->employee_id) AND end_date is null");


        if($confirmation_date<$check_data[0]->start_date){
             $request->session()->flash('alert-danger', 'Sorry you can not give back date employee activity!');        
             return Redirect::to('/'); 
                           
        }


        $find_data=DB::SELECT("SELECT id FROM hrm_employee_activity WHERE hrm_employee_activity_status_id=8
        AND hrm_employee_job_info_id in (SELECT id from hrm_employee_job_info WHERE hrm_employee_id=$request->employee_id)");
        // dd($find_data);

        if(!empty($find_data)){
            $request->session()->flash('alert-danger', 'Sorry this employee already confirm previous time. please check!');   
             return Redirect::to('/'); 
                           
        }


       DB::beginTransaction();
        try{

        $employeeinfo = HrmEmployeeProbation::where('hrm_employee_id', $request->employee_id)->first();
        $update_probation                = HrmEmployeeProbation::find($employeeinfo->id);
        $update_probation->note          = '$request->note';
        $update_probation->users_id      = Auth::user()->id;
        $update_probation->save();


     


        $insert_joining      = HrmEmployeeJoining::where('hrm_employee_id', $request->employee_id)->first();
        $insert_joining->confirmation_date  = $confirmation_date;
        $insert_joining->save();


        $oldinfo    = HrmEmployeeJobInfo::find($jobid);
        $insert     = new HrmEmployeeJobInfo;
        $insert->hrm_employee_id            = $oldinfo->hrm_employee_id;
        $insert->employee_code              = $oldinfo->employee_code;
        $insert->hrm_depertment_id          = $oldinfo->hrm_depertment_id; 
        $insert->hrm_designation_id         = $oldinfo->hrm_designation_id; 
        $insert->hrm_category_id            = $oldinfo->hrm_category_id; 
        $insert->hrm_employment_status_id   = $request->employeestatus; 
        $insert->hrm_manage_by_id           = $oldinfo->hrm_manage_by_id;
        $insert->employee_shift_status      = 1;
        $insert->overtime_status            = $oldinfo->overtime_status;
        $insert->hrm_plant_id               = $oldinfo->hrm_plant_id;
        $insert->employee_activity          = 1; 
        $insert->basic_salary               = $request->new_salary;
        $insert->hrm_location_id            = $oldinfo->hrm_location_id;
        $insert->hrm_section_id             = $oldinfo->hrm_section_id;
        $insert->insurance                  = $oldinfo->insurance;
        $insert->users_id                   = Auth::user()->id;
        $insert->save();


        $oldcard = DB::SELECT("SELECT * FROM hrm_employee_card_code Where hrm_employee_job_info_id = $jobid");
        
        if(!empty($oldcard)){
            $insert_card     = new HrmEmployeeCardCode;
            $insert_card->card_code                = $oldcard[0]->card_code;
            $insert_card->device_id                = $oldcard[0]->device_id;
            $insert_card->hrm_employee_job_info_id = $insert->id;
            $insert_card->save();
        }

        $oldshift = DB::SELECT("SELECT * FROM hrm_employee_shift Where hrm_employee_job_info_id = $jobid and end_date is null ");
        
        $end_shift_date   = $oldshift[0]->start_date;  
        $start_shift_date =date('Y-m-d', strtotime($end_shift_date." +1 days"));   

        $insert_shift  = new HrmEmployeeShift;
        $insert_shift->hrm_employee_job_info_id = $insert->id;  
        $insert_shift->hrm_shift_id             = $oldshift[0]->hrm_shift_id;
        $insert_shift->start_date               = $start_shift_date;
        $insert_shift->comment                  = 'from probation to confirm2.';
        $insert_shift->users_id                 = Auth::user()->id;
        $insert_shift->valid                    = 1;
        $insert_shift->save();

        $oldsalary  = DB::SELECT("SELECT * FROM hrm_employee_salary WHERE hrm_employee_job_info_id = $jobid ");

        $insert_salary_master  = new HrmEmployeeSalary;
        $insert_salary_master->hrm_employee_job_info_id   = $insert->id;  
        $insert_salary_master->hrm_salary_grade_master_id = $request->salary_grade;
        $insert_salary_master->salary_amount              = $request->new_salary;
        $insert_salary_master->users_id                   = Auth::user()->id;
        $insert_salary_master->payment_mode               = $oldsalary[0]->payment_mode;
        $insert_salary_master->account_no                 = $oldsalary[0]->account_no;
        $insert_salary_master->hrm_bank_id                = $oldsalary[0]->hrm_bank_id;
        $insert_salary_master->accounts_code              = $oldsalary[0]->accounts_code;
        $insert_salary_master->save();

        $hrm_salary_grade_master_id = $request->salary_grade;
        $salary_grade_details       = DB::SELECT("SELECT a.* FROM hrm_salary_grade_details a JOIN
                                    hrm_salary_head b ON a.hrm_salary_head_id = b.id and b.apply_for=1 and hrm_salary_grade_master_id=$hrm_salary_grade_master_id");
        $count_row                  = count($salary_grade_details);

        for($r = 0; $r <$count_row; $r++) {


           $gross_salary       = $request->new_salary;   
           $amount             = $salary_grade_details[$r]->amount;
           $amount_type        = $salary_grade_details[$r]->amount_type;
           $hrm_salary_head_id = $salary_grade_details[$r]->hrm_salary_head_id;

              if($amount_type==2){
                       $actual_amount = $amount;   
              }else{
                       $actual_amount = ($gross_salary*$amount/100);    
              }    
          
       //provident fund amount calculation basic er 10%    
          $group_status_data=DB::SELECT("SELECT b.group_status FROM hrm_salary_head a JOIN hrm_salary_head_group b 
                                    ON a.hrm_salary_head_group_id = b.id WHERE a.id = $hrm_salary_head_id");
                                   
          $salary_group_status = $group_status_data[0]->group_status;

          // dd($salary_group_status);

          if($salary_group_status == 4){
            $basic_salary_amount=($gross_salary*60/100);
            $actual_amount=($basic_salary_amount*10/100);
            // dd($actual_amount);

          }
           
           //END provident fund amount calculation basic er 10% 

            $insert_salary_details  = new HrmEmployeeSalaryDetails;
            $insert_salary_details->hrm_employee_salary_id     = $insert_salary_master->id; 
            $insert_salary_details->hrm_salary_head_id         = $salary_grade_details[$r]->hrm_salary_head_id;
            $insert_salary_details->amount                     = $salary_grade_details[$r]->amount;
            $insert_salary_details->amount_type                = $salary_grade_details[$r]->amount_type;
            $insert_salary_details->actual_amount              = $actual_amount;
            $insert_salary_details->save();
        }


            $insert_employee_activity  = new HrmEmployeeActivity;
            $insert_employee_activity->hrm_employee_job_info_id        = $insert->id;  
            $insert_employee_activity->activity_date                   = $ldate;
            $insert_employee_activity->comment                         = 'Probation to Confirmation';
            $insert_employee_activity->users_id                        = Auth::user()->id;
            $insert_employee_activity->activity                        = 1;
            $insert_employee_activity->hrm_employee_activity_status_id = 8;
            $insert_employee_activity->start_date                      = $confirmation_date;
            $insert_employee_activity->old_hrm_employee_job_info_id    = $jobid;  
            $insert_employee_activity->save();



            DB::update("UPDATE hrm_employee_activity SET end_date = '$end_date'
                        WHERE end_date is null AND hrm_employee_job_info_id = $jobid"); 
            
            DB::update("UPDATE hrm_employee_job_info SET employee_activity = 0 
                        WHERE id = $request->hrm_employee_job_info_id ");    

            DB::update("UPDATE hrm_employee_shift SET end_date= '$end_shift_date',comment='from probation to confirm.',users_id= $user_id,updated_at='$ldate'  WHERE  end_date is null AND hrm_employee_job_info_id = $request->hrm_employee_job_info_id  ");    




            $is_apply_fb = HrmFringeBenefitsConfig::where('hrm_designation_id', $oldinfo->hrm_designation_id)->first();

            if (!empty($is_apply_fb)){

                $fb_details = DB::SELECT("SELECT * FROM hrm_fringe_benefits_config_details 
                              WHERE hrm_fringe_benefits_config_id = $is_apply_fb->id");
                $count_row            = count($fb_details);

                for($r = 0; $r <$count_row; $r++) {

                    $insert_fb_details  = new HrmEmployeeSalaryDetails;
                    $insert_fb_details->hrm_employee_salary_id     = $insert_salary_master->id; 
                    $insert_fb_details->hrm_salary_head_id         = $fb_details[$r]->hrm_salary_head_id;
                    $insert_fb_details->amount                     = $fb_details[$r]->amount;
                    $insert_fb_details->amount_type                = $fb_details[$r]->amount_type;
                    $insert_fb_details->actual_amount              = $fb_details[$r]->amount;
                    $insert_fb_details->save();

                }
            }



        DB::commit();
        } catch (\Exception $e) {
        DB::rollback();
        return Response::json(array(
            'success'           => false,
            'error_messages'    => true,
            'errors'          => "insert problem !! " . $e->getMessage()
        ));         
        }    

        $request->session()->flash('alert-success', 'successfully updated!');        
        return Redirect::to('home'); 

    }

  public function common_dashboard(Request $request,$id)
    {

        $user_id    =Auth::user()->id;
        $company_name=Config::get('configaration.company_name');
        $address     =Config::get('configaration.company_address');

        if($id==1){

                $title       ="Location Wise Employee List";

                $data      = DB::SELECT("SELECT 
                                                b.id,
                                                b.location_name AS description,
                                                COUNT(a.id) AS count_employee
                                            FROM
                                                hrm_employee_job_info a
                                                    JOIN
                                                hrm_location b ON a.hrm_location_id = b.id
                                                    JOIN
                                                user_location c ON c.hrm_location_id = b.id
                                                    AND c.users_id = $user_id
                                            WHERE
                                                employee_activity = 1
                                            GROUP BY b.id , b.location_name");

                if (empty($data)){
                session()->flash('alert-danger', 'Invalid Request !!');        
                return Redirect()->back();                          
                }



        }

      if($id==2){

        $title       ="Department Wise Employee List";
        $data      = DB::SELECT("SELECT 
                                            cc.id,cc.depertment_name as description, COUNT(a.id) AS count_employee
                                        FROM
                                            hrm_employee_job_info a
                                                JOIN
                                            hrm_location b ON a.hrm_location_id = b.id
                                                JOIN
                                            hrm_depertment cc ON a.hrm_depertment_id=cc.id
                                                JOIN
                                            user_location c ON c.hrm_location_id = b.id
                                                AND c.users_id = $user_id
                                        WHERE
                                            employee_activity = 1
                                        GROUP BY cc.id,cc.depertment_name");

        if (empty($data)){
        session()->flash('alert-danger', 'Invalid Request !!');        
        return Redirect()->back();                          
        }


       }
        if($id==3){

                $title       ="Location Wise Probation Employee List";

                $data      = DB::SELECT("SELECT 
                                            cc.id,
                                            cc.depertment_name AS description,
                                            COUNT(a.id) AS count_employee
                                        FROM
                                            hrm_employee_job_info a
                                                JOIN
                                            hrm_location b ON a.hrm_location_id = b.id AND a.hrm_employment_status_id=1
                                                JOIN
                                            hrm_depertment cc ON a.hrm_depertment_id = cc.id
                                                JOIN
                                            user_location c ON c.hrm_location_id = b.id
                                                AND c.users_id = $user_id
                                        WHERE
                                            employee_activity = 1
                                        GROUP BY cc.id , cc.depertment_name");

                if (empty($data)){
                session()->flash('alert-danger', 'Invalid Request !!');        
                return Redirect()->back();                          
                }



        }
        if($id==4){

                $title       ="Location Wise Employee List";

                $data      = DB::SELECT("SELECT 
                                            b.id,
                                            b.location_name AS description,
                                            COUNT(a.id) AS count_employee
                                        FROM
                                            hrm_employee_job_info a
                                                JOIN
                                            hrm_location b ON a.hrm_location_id = b.id
                                                JOIN
                                            user_location c ON c.hrm_location_id = b.id
                                                AND c.users_id = $user_id
                                        WHERE
                                            employee_activity = 1
                                        GROUP BY b.id , b.location_name");

                if (empty($data)){
                session()->flash('alert-danger', 'Invalid Request !!');        
                return Redirect()->back();                          
                }



        }        


        return view('dashboard.common_dashboard')
              ->with('data',$data)
              ->with('title',$title)
              ->with('company_name',$company_name)
              ->with('address',$address);
    }




    public function probation($id)
    {
        $user_id=Auth::user()->id;

        $probation_employee=DB::SELECT("SELECT 
                                            a.id,
                                            CONCAT(a.employee_name, ' | ', b.employee_code) AS employee_name,
                                            c.location_name,
                                            d.depertment_name,
                                            e.designation_name,
                                            a.contact_number,
                                            f.joining_date,
                                            a.Images,
                                            b.basic_salary,
                                            b.id AS hrm_employee_job_info_id,
                                            DATE_ADD(f.joining_date,
                                                INTERVAL h.period MONTH) AS probable_date
                                        FROM
                                            hrm_employee a
                                                JOIN
                                            hrm_employee_job_info b ON a.id = b.hrm_employee_id
                                                AND a.active_status = 1
                                                AND b.employee_activity = 1
                                                AND a.id = $id
                                                JOIN
                                            hrm_location c ON b.hrm_location_id = c.id
                                                JOIN
                                            hrm_depertment d ON b.hrm_depertment_id = d.id
                                                JOIN
                                            hrm_designation e ON b.hrm_designation_id = e.id
                                                JOIN
                                            hrm_employee_joining f ON b.hrm_employee_id = f.hrm_employee_id
                                                JOIN
                                            hrm_employee_probation g ON a.id = g.hrm_employee_id
                                                JOIN
                                            hrm_probation_period h ON g.hrm_probation_period_id = h.id
                                                JOIN
                                            user_location i ON b.hrm_location_id = i.hrm_location_id
                                                AND i.users_id = $user_id ");
    
       return view('dashboard.probation_employee')
        ->with('probation_employee',$probation_employee);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cancel(Request $request,$id){          

    }    
}
