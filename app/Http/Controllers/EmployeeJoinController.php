<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Redirect;
use Auth;
use DB;
use DataTables;
use Crypt;
use Validator;
use Config;
use Session;
use Response;
use DateTime;


use App\models\HrmEmployeeJobInfo;
use App\models\HrmEmployeeJoining;
use App\models\HrmEmployeeShift;
use App\models\HrmReligion;
use App\models\HrmMaritalStatus;
use App\models\HrmBloodGroup;
use App\models\HrmEmployee;
use App\models\HrmEmployeeTransfer;
use App\models\HrmEmployeeSalary;
use App\models\HrmEmployeeSalaryDetails;
use App\models\HrmSalaryGradeMaster;
use App\models\HrmSalaryGradeDetails;
use App\models\HrmEmployeeCardCode;
use App\models\HrmProbationPeriod;
use App\models\HrmEmployeeProbation;
use App\models\HrmRedflag;
use App\models\HrmEmployeeActivity;
use App\models\HrmPlantWiseEmployee;
use App\models\HrmFringeBenefitsConfig;






class EmployeeJoinController extends Controller
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

        $user_id = Auth::user()->id;
        $default_user_location = DB::select("SELECT b.id,b.location_name FROM `user_location` a JOIN hrm_location b ON a.`hrm_location_id`= b.id and a.`users_id`= $user_id AND a.`default_location`=1");          


        return view('employee.active_employee_list')
        -> with('default_user_location',  $default_user_location) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function create()
    {
        return view('employee.create_employee')
            ->with('religion',HrmReligion::all())
            ->with('marital_status',HrmMaritalStatus::all())
            ->with('blood_group',HrmBloodGroup::all());
    }



   public function current_employeelist(Request $request){



        if($request->redflagStatus==1){
            $redflagStatus="AND h.id is not null";
        }else{
            $redflagStatus = "";
        }


        if($request->location==null){
            $location="";
        }else{
            $location = "AND b.hrm_location_id=$request->location";
        }

        $user_id=Auth::user()->id;
     

        $currentemployee = DB::select("SELECT a.id,
                                concat(a.employee_name,' | ',b.employee_code) as employee_name,
                                c.location_name,
                                LPAD(a.id, 5, '0') as Unique_Code,
                                d.depertment_name,
                                e.designation_name,
                                a.contact_number,
                                DATE_FORMAT(f.joining_date,'%d-%m-%Y') as joining_date, 
                                h.id as redflag,
                                e.priority,
                                a.Images 
                                from  hrm_employee a 
                                JOIN hrm_employee_job_info b on a.id=b.hrm_employee_id AND  a.active_status=1 AND b.employee_activity=1 
                                Join hrm_location c On b.hrm_location_id=c.id 
                                JOIN hrm_depertment d On b.hrm_depertment_id=d.id 
                                Join hrm_designation e On b.hrm_designation_id=e.id 
                                Join hrm_employee_joining f on b.hrm_employee_id=f.hrm_employee_id
                                LEFT JOIN hrm_redflag h ON a.id = h.hrm_employee_id
                                JOIN user_location g ON b.hrm_location_id = g.hrm_location_id AND g.users_id = $user_id   $location  $redflagStatus") ;

        return DataTables::of($currentemployee)
        ->addColumn('Link', function ($currentemployee) {
           return 
           ' <a href="'. url('/employeejoin') . '/' . 
           Crypt::encrypt($currentemployee->id) . 
           '/edit' .'"' . 
           'class="btn  btn-sm block btn-flat"><i class="glyphicon glyphicon-edit" id="customer-confrimed"></i> Edit</a>';        
         })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->rawColumns(['Link'])
        ->make(true);

    }
   
   public function employeeidcard()
    {
        $user_id = Auth::user()->id;
        $user_location = DB::select("SELECT a.id,a.location_name,b.default_location FROM hrm_location a JOIN user_location b ON a.id=b.hrm_location_id AND b.users_id = $user_id");
        return view('join_employee.employeeidcard')
        -> with('default_user_location',  $user_location) ;
    }
    



    public function employeeidcardlistdata(Request $request){


        $condition    = "a.active_status=1";

        if ($request->employeeid != 0){
          $condition  = $condition. " AND b.hrm_employee_id = ".$request->employeeid;
        }
       
        if ($request->location != 0){
          $condition  = $condition. " AND b.hrm_location_id = ".$request->location;
        }

        if ($request->working_shift_id != 0){
          $condition  =  $condition . " AND d.id = ".$request->working_shift_id ;
        }

        if ($request->department_id != 0){
          $condition  =  $condition . " AND e.id = ".$request->department_id ;
        }
        
        if ($request->designation_id != 0){
          $condition  =  $condition . " AND f.id = ".$request->designation_id ;
        }
// dd($condition);
        
        $data   = DB::select("SELECT
                                a.id, 
                                concat(a.employee_name,' | ',b.employee_code) as employee_name,
                                e.depertment_name,
                                f.designation_name,
                                g.location_name,
                                d.shift_name
                            FROM
                                hrm_employee a
                                    JOIN
                                hrm_employee_job_info b ON b.hrm_employee_id = a.id and b.employee_activity=1
                                    JOIN
                                hrm_employee_shift c ON c.hrm_employee_job_info_id = b.id And c.end_date IS NULL
                                    JOIN
                                hrm_shift d ON c.hrm_shift_id = d.id
                                    JOIN
                                hrm_depertment e ON b.hrm_depertment_id = e.id
                                    JOIN
                                hrm_designation f ON b.hrm_designation_id = f.id
                                    JOIN
                                hrm_location g ON b.hrm_location_id = g.id
                                    Where 
                                    $condition
                            ");

        return json_encode(array('data' => $data)); 

    }
    
    public function submitemployeeidcard(Request $request)
    {
     
        $links = implode(',', array_values($request->id));
        $data   = DB::select("SELECT
                        a.id,
                        a.Images, 
                        a.employee_name,
                        b.employee_code,
                        e.depertment_name,
                        f.alis as designation_name,
                        g.location_name,
                        d.shift_name,
                        DATE_FORMAT(h.joining_date,'%d-%m-%Y') as joining_date,
                        DATE_FORMAT(a.dob,'%d-%m-%Y') as dob ,
                        i.blood_group
                    FROM
                        hrm_employee a
                            JOIN
                        hrm_employee_job_info b ON b.hrm_employee_id = a.id and b.employee_activity=1 and
                            a.id in ($links)
                            JOIN
                        hrm_employee_shift c ON c.hrm_employee_job_info_id = b.id And c.end_date IS NULL
                            JOIN
                        hrm_shift d ON c.hrm_shift_id = d.id
                            JOIN
                        hrm_depertment e ON b.hrm_depertment_id = e.id
                            JOIN
                        hrm_designation f ON b.hrm_designation_id = f.id
                            JOIN
                        hrm_location g ON b.hrm_location_id = g.id
                            Join
                        hrm_employee_joining h ON a.id=h.hrm_employee_id
                            JOIN
                        hrm_blood_group i On a.hrm_blood_group_id= i.id     ");

        return view('join_employee.employeeidcardreport')
        -> with('data',  $data);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_name'     => 'required',
            'depertment'        => 'required|exists:hrm_depertment,id',
            'designation'       => 'required|exists:hrm_designation,id',
            'category'          => 'required|exists:hrm_category,id',
            'jod_location'      => 'required|exists:hrm_location,id',
            'section'           => 'required|exists:hrm_section,id',
            'working_shift'     => 'required|exists:hrm_shift,id',
            'overtime'          => 'required',
            'manage_by'         => 'required|exists:hrm_employee,id',
            'employeestatus'    => 'required|exists:hrm_employment_status,id',
            'basic_salary'      => 'required',
        ]);

        if ($validator->fails()) {
            // return Redirect()->back()
            //             ->withErrors($validator)
            //             ->withInput();
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $joining_date       = date('Y-m-d', strtotime(str_replace('/', '-', $request->joining_date)));
        $confirmation_date  = date('Y-m-d', strtotime(str_replace('/', '-', $request->confirmation_date)));
        $currentdate        = date('Y-m-d');

        $employeejobinfo = HrmEmployeeJobInfo::where('hrm_employee_id', $request->employee_name)->first();

        if (!empty($employeejobinfo)){
            session()->flash('alert-danger', 'This Employee Already Joined !!');        
            return Redirect()->back();              
        }



            DB::beginTransaction();
            try{

                $insert     = new HrmEmployeeJobInfo;
                $insert->hrm_employee_id            = $request->employee_name;
                $insert->employee_code              = $request->employee_code;
                $insert->hrm_depertment_id          = $request->depertment; 
                $insert->hrm_designation_id         = $request->designation; 
                $insert->hrm_category_id            = $request->category; 
                $insert->hrm_employment_status_id   = $request->employeestatus; 
                $insert->hrm_manage_by_id           = $request->manage_by;
                $insert->employee_shift_status      = 1;
                $insert->overtime_status            = $request->overtime;
                $insert->employee_activity          = 1; 
                $insert->basic_salary               = $request->basic_salary;
                $insert->hrm_location_id            = $request->jod_location;
                $insert->hrm_section_id             = $request->section;
                $insert->hrm_plant_id               = $request->plant_name;
                $insert->insurance                  = $request->insurance;
                $insert->users_id                   = Auth::user()->id;
                $insert->save();

                $insert_shift  = new HrmEmployeeShift;
                $insert_shift->hrm_employee_job_info_id = $insert->id;  
                $insert_shift->hrm_shift_id             = $request->working_shift;
                $insert_shift->start_date               = $joining_date;
                $insert_shift->valid                    = 1;
                $insert_shift->comment                  = 'NewJoin';
                $insert_shift->users_id                 = Auth::user()->id;
                $insert_shift->save();


                $insert_joining      = new HrmEmployeeJoining;
                $insert_joining->hrm_employee_id    = $request->employee_name;
                $insert_joining->joining_date       = $joining_date;

                if($request->employeestatus==1){
                    // $employeejoining->confirmation_date  = null;
                }else{
                    $insert_joining->confirmation_date  = $confirmation_date;
                }

                $insert_joining->save();

// dd("WORKING....");

                $insert_activity      = new HrmEmployeeActivity;
                $insert_activity->hrm_employee_job_info_id   = $insert->id;
                $insert_activity->activity_date              = $currentdate;
                $insert_activity->comment                    = 'Join';
                $insert_activity->users_id                   = Auth::user()->id;
                $insert_activity->activity                   = 3;
                $insert_activity->hrm_employee_activity_status_id = 1;
                $insert_activity->start_date                 = $joining_date;
                $insert_activity->save();

                // if ($request->employeestatus==3){

                //     $insert_plant                           = new HrmPlantWiseEmployee;
                //     $insert_plant->hrm_plant_id             = $request->plant_name ;
                //     $insert_plant->hrm_employee_job_info_id = $insert->id;  
                //     $insert_plant->save();

                // }

                if ($request->employeestatus==1){

                    $insert_probation      = new HrmEmployeeProbation;
                    $insert_probation->hrm_employee_id          = $request->employee_name;
                    $insert_probation->hrm_probation_period_id  = $request->probation_period;
                    $insert_probation->users_id                 = Auth::user()->id;
                    $insert_probation->save();

                }



//Image Update
                $employeeImage =DB::select("SELECT Images from hrm_employee  Where id= $request->employee_name");
                $fileName= $employeeImage[0]->Images;

                $employee = HrmEmployee::find($request->employee_name);

                if(!empty($request->images)) {     
                    $valid_exts = array('jpeg', 'jpg', 'png', 'gif');     // valid extensions
                    $max_size = 2000 * 1024;                              // max file size (200kb)
                    $path = public_path() . '/employee_image/'; // upload directory
                    $file = $request->images;
                    $ext  = $file->guessClientExtension();
                    $size = $file->getClientSize();
                    $name = $this->generateRandomString();
                    if (in_array($ext, $valid_exts) AND $size < $max_size){
                        if ($file->move($path, $name)){
                            $status = 'Image successfully uploaded!';
                            $fileName = $name;
                        }
                    }


                    $employee->Images                 = $fileName;
                    $employee->save();
                }else{
                    $employee->Images                 = $fileName;
                    $employee->save();
                }


                //End Image Update
                //Salary Related Information Insert
                //$payroll_module         = Config::get('module_config.payroll_module');
                //if($payroll_module == 1){
              
                if(Config::get('module_config.payroll_module') == 1){


                    $salary_grade_master  = HrmSalaryGradeMaster::where('hrm_salary_grade_id', $request->salary_grade)->first(); 

                    $insert_salary_master  = new HrmEmployeeSalary;
                    $insert_salary_master->hrm_employee_job_info_id   = $insert->id;  
                    $insert_salary_master->hrm_salary_grade_master_id = $salary_grade_master->id;
                    $insert_salary_master->salary_amount              = $request->basic_salary;
                    $insert_salary_master->users_id                   = Auth::user()->id;
                    $insert_salary_master->payment_mode               = 1;
                    $insert_salary_master->account_no                 = '';
                    // $insert_salary_master->hrm_bank_id             = 1;
                    $insert_salary_master->save();


                    $salary_grade_details = DB::SELECT("SELECT * FROM hrm_salary_grade_details WHERE hrm_salary_head_id IN (SELECT id FROM hrm_salary_head WHERE apply_for=1) AND  hrm_salary_grade_master_id=$salary_grade_master->id");
                    
                    $count_row            = count($salary_grade_details);


                    for($r = 0; $r <$count_row; $r++) {

                       $basic_salary       = $request->basic_salary;    
                       $amount             = $salary_grade_details[$r]->amount;
                       $amount_type        = $salary_grade_details[$r]->amount_type;
                       $hrm_salary_head_id = $salary_grade_details[$r]->hrm_salary_head_id;

                      if($amount_type==2){
                               $actual_amount = $amount;   
                      }else{
                               $actual_amount = ($basic_salary*$amount/100);    
                      }    
                      
                      //provident fund amount calculation basic er 10%    
                      $group_status_data = DB::SELECT("SELECT b.group_status 
                                                     FROM hrm_salary_head a 
                                                     JOIN hrm_salary_head_group b 
                                                     ON a.hrm_salary_head_group_id = b.id 
                                                     WHERE a.id = $hrm_salary_head_id");
                                               
                      $salary_group_status = $group_status_data[0]->group_status;

                      // dd($salary_group_status);

                      if($salary_group_status==4){
                        
                        if($salary_grade_details[$r]->amount>0){
                            $basic_salary_amount =($basic_salary*60/100);
                            $actual_amount       =($basic_salary_amount*10/100);
                        }else{
                             $actual_amount = 0;
                        }

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

                    $is_apply_fb = HrmFringeBenefitsConfig::where('hrm_designation_id', $request->designation)->first();

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


                }
            //END Salary Related Information Insert

            if(!empty($request->card_no)) {    

                $isExist = DB::SELECT("SELECT 
                                            b.id
                                        FROM
                                            hrm_employee_card_code a
                                                JOIN
                                            hrm_employee_job_info b ON b.id = a.hrm_employee_job_info_id  AND b.employee_activity=1
                                        WHERE
                                              b.hrm_location_id = $request->jod_location
                                              AND a.device_id   = $request->device_id
                                              AND a.card_code   ='$request->card_no'");

                if(!empty($isExist)){
                    // $request->session()->flash('alert-danger', 'Sorry This Card No. Already Exists!');        
                    // return Redirect()->back(); 
                    return response()->json(['errors'=>'Sorry Your This Card No. Already Exists!']);
                }

                $insert_card     = new HrmEmployeeCardCode;
                $insert_card->card_code                = $request->card_no;
                $insert_card->device_id                = $request->device_id;
                $insert_card->hrm_employee_job_info_id = $insert->id;
                $insert_card->save();
            }


            DB::commit();    
            }catch (\Exception $e) {
                DB::rollback();
                // $validator->errors()->add('field', $e->getMessage());
                // return response()->json($validator->errors()->all()); 
                return response()->json(['errors'=>$validator->errors()->add('field', $e->getMessage())]);       

            } 

            // $request->session()->flash('alert-success', 'data has been successfully added!');        
            // return Redirect::to('employee');         
           // return response::json(array(
           //      'success'   => true,
           //      'messages'  => 'successfully employee add!'
           // ));
           return response()->json(['success'=>'Record is successfully Insert']);


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
         $id = Crypt::decrypt($id);

         $employee = HrmEmployee::find($id);



        if (empty($employee)){
            session()->flash('alert-danger', 'Invalid employee !!');        
            return Redirect()->back();    
        }



        $editemployee = DB::select("SELECT a.id,
                                a.employee_name,
                                b.id as hrm_employee_job_info_id,
                                b.employee_code,
                                c.id as location_id,
                                c.location_name,
                                d.id as department_id,
                                d.depertment_name,
                                e.id as designation_id,
                                e.designation_name,
                                b.basic_salary,
                                a.contact_number,
                                f.joining_date,
                                f.confirmation_date,
                                g.id as employeestatus_id,
                                g.employment_status as employeestatus_name,
                                h.id as category_id,
                                h.category_name,
                                i.id as sectionid,
                                i.section_name,
                                b.overtime_status,
                                j.id as manage_by_id,
                                j.employee_name as manage_by_name,
                                l.id as shift_id,
                                l.shift_name,
                                m.id as plant_id,
                                m.plant_name,
                                a.Images,
                                b.insurance,
                                s.period,
                                r.hrm_probation_period_id
                                from hrm_employee a 
                                JOIN hrm_employee_job_info b on a.id=b.hrm_employee_id  AND a.active_status=1 and b.employee_activity=1 and a.id=$id 
                                Join hrm_location c On b.hrm_location_id=c.id 
                                JOIN hrm_depertment d On b.hrm_depertment_id=d.id 
                                Join hrm_designation e On b.hrm_designation_id=e.id 
                                Join hrm_employee_joining f on b.hrm_employee_id=f.hrm_employee_id
                                Join hrm_employment_status g On b.hrm_employment_status_id=g.id
                                Join hrm_category h on b.hrm_category_id=h.id
                                Join hrm_section i on b.hrm_section_id=i.id
                                join hrm_employee j on b.hrm_manage_by_id=j.id
                                Join hrm_employee_shift k on b.id=k.hrm_employee_job_info_id And k.end_date is null
                                Join hrm_shift l on k.hrm_shift_id=l.id
                                JOIN hrm_plant m ON m.id=b.hrm_plant_id
                                LEFT JOIN hrm_employee_probation r ON r.hrm_employee_id = a.id
                                LEFT JOIN hrm_probation_period s ON r.hrm_probation_period_id = s.id 
                                ") ;


         $employee_salary_grade='';
         if(Config::get('module_config.payroll_module') == 1){
            $hrm_employee_job_info_id  = HrmEmployeeJobInfo::where('hrm_employee_id',$id)->first(); 
            $hrm_employee_salary_info  = HrmEmployeeSalary::where('hrm_employee_job_info_id',$hrm_employee_job_info_id->id)->first(); 
           
            $employee_salary_grade= DB::SELECT("SELECT 
                                                    b.id,
                                                    b.grade_name
                                                FROM
                                                    hrm_salary_grade_master a
                                                        JOIN
                                                    hrm_salary_grade b ON b.id = a.hrm_salary_grade_id
                                                        AND a.id=$hrm_employee_salary_info->hrm_salary_grade_master_id");

         }

        return view('join_employee.edit_join_employee')
            ->with('employee',$employee)
            ->with('editemployee',$editemployee)
            ->with('employee_salary_grade',$employee_salary_grade)
            ->with('religion',HrmReligion::all())
            ->with('probation',HrmProbationPeriod::all())
            ->with('marital_status',HrmMaritalStatus::all())
            ->with('blood_group',HrmBloodGroup::all());        
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

        // dd("NOMAN");

         $validator = Validator::make($request->all(), [
            'employee_name'     => 'required',
            'depertment'        => 'required|exists:hrm_depertment,id',
            'designation'       => 'required|exists:hrm_designation,id',
            'category'          => 'required|exists:hrm_category,id',
            'jod_location'      => 'required|exists:hrm_location,id',
            'section'           => 'required|exists:hrm_section,id',
            'working_shift'     => 'required|exists:hrm_shift,id',
            'overtime'          => 'required',
            'manage_by'         => 'required|exists:hrm_employee,id',
            'employeestatus'    => 'required|exists:hrm_employment_status,id',
            'basic_salary'      => 'required',
        ]);

        if ($validator->fails()) {
             return response()->json(['errors'=>$validator->errors()->all()]);
        }


        $joining_date       = date('Y-m-d', strtotime(str_replace('/', '-', $request->joining_date)));
        $confirmation_date  = date('Y-m-d', strtotime(str_replace('/', '-', $request->confirmation_date)));

 
            DB::beginTransaction();
            try{

                $employeejobinfo = HrmEmployeeJobInfo::where('hrm_employee_id', $id)
                                ->where('employee_activity', 1)
                                ->first();
                $employeejobinfo = HrmEmployeeJobInfo::find($employeejobinfo->id);
                $employeejobinfo->hrm_employee_id            = $request->get('employee_name');
                $employeejobinfo->employee_code              = $request->get('employee_code');
                $employeejobinfo->hrm_depertment_id          = $request->get('depertment'); 
                $employeejobinfo->hrm_designation_id         = $request->get('designation'); 
                $employeejobinfo->hrm_category_id            = $request->get('category'); 
                $employeejobinfo->hrm_employment_status_id   = $request->get('employeestatus'); 
                $employeejobinfo->hrm_manage_by_id           = $request->get('manage_by');
                $employeejobinfo->employee_shift_status      = 1;
                $employeejobinfo->overtime_status            = $request->get('overtime');
                $employeejobinfo->employee_activity          = 1; 
                $employeejobinfo->basic_salary               = $request->get('basic_salary');
                $employeejobinfo->hrm_location_id            = $request->get('jod_location');
                $employeejobinfo->hrm_section_id             = $request->get('section');
                $employeejobinfo->hrm_plant_id               = $request->get('plant_name');
                $employeejobinfo->insurance                  = $request->get('insurance');
                $employeejobinfo->users_id                   = Auth::user()->id;
                $employeejobinfo->save();

                // $employeejoining = HrmEmployeeJoining::where('hrm_employee_id', $id)->first();
                // $employeejoining = HrmEmployeeJoining::find($employeejoining->id);
                // $employeejoining->hrm_employee_id    = $request->get('employee_name');
                // $employeejoining->joining_date       = $joining_date;
                // $employeejoining->confirmation_date  = $confirmation_date;
                // $employeejoining->save();

                if($request->employeestatus==1){
                    DB::UPDATE("UPDATE hrm_employee_joining SET joining_date='$joining_date',confirmation_date=null WHERE hrm_employee_id=$id");
                }else{

                    DB::UPDATE("UPDATE hrm_employee_joining SET joining_date='$joining_date',confirmation_date='$confirmation_date' WHERE hrm_employee_id=$id");
                }

                if ($request->employeestatus==1){

                    DB::table('hrm_employee_probation')->where('hrm_employee_id', '=', $request->employee_name)->delete();

                    $insert_probation      = new HrmEmployeeProbation;
                    $insert_probation->hrm_employee_id          = $request->employee_name;
                    $insert_probation->hrm_probation_period_id  = $request->probation_period;
                    $insert_probation->users_id                 = Auth::user()->id;


                    $insert_probation->save();

                }

                // $jobid           = $request->hrm_employee_job_info_id;
                // $insert_activity = HrmEmployeeActivity::where('hrm_employee_job_info_id',$jobid)->first();
                // $insert_activity = HrmEmployeeActivity::find($insert_activity->id);
                // $insert_activity->start_date    = $joining_date;
                // $insert_activity->save();


                $jobid = $request->hrm_employee_job_info_id;
                DB::update("UPDATE  hrm_employee_activity SET start_date='$joining_date' WHERE hrm_employee_job_info_id =$jobid AND hrm_employee_activity_status_id=1");

        // SHIFT CHANGE NOT PERMITE FROM HERE,Problem in date maintain (NOMAN) any query Knock Me.


            //     //Check  Shift Data
            //     $employee_shift_id= $request->get('working_shift');
            //     $employee_jobinfo_id= $request->get('hrm_employee_job_info_id');
            //     $isExitDatabase =DB::select("SELECT id from hrm_employee_shift  Where hrm_employee_job_info_id=$employee_jobinfo_id and hrm_shift_id = $employee_shift_id and end_date is null");
            //     //End Check Data

            // if (empty($isExitDatabase)){

            //     $ldate = date('Y-m-d H:i:s');

            //     $employeeshift   = HrmEmployeeShift::where('hrm_employee_job_info_id', $request->hrm_employee_job_info_id)
            //                                        ->where('end_date',null)->first(); 
            //     $employeeshift->end_date                 = $ldate;
            //     $employeeshift->valid                    = 1;
            //     $employeeshift->save();


            //     $insert_shift  = new HrmEmployeeShift;
            //     $insert_shift->hrm_employee_job_info_id = $request->get('hrm_employee_job_info_id');   
            //     $insert_shift->hrm_shift_id             = $request->get('working_shift');
            //     $insert_shift->start_date               = $ldate;
            //     $insert_shift->valid                    = 1;
            //     $insert_shift->save();
                   
            //     }


            //image Update 

            $employee = HrmEmployee::find($id);

            if(!empty($request->images)) {     
                $valid_exts = array('jpeg', 'jpg', 'png', 'gif');     // valid extensions
                $max_size = 2000 * 1024;                              // max file size (200kb)
                $path = public_path() . '/employee_image/'; // upload directory
                // dd($path);
                // if ($employee->Images != null){
                //     unlink($path.$employee->Images);
                // }
                $file = $request->images;
                $ext  = $file->guessClientExtension();
                $size = $file->getClientSize();
                $name = $this->generateRandomString();
                if (in_array($ext, $valid_exts) AND $size < $max_size){
                    if ($file->move($path, $name)){
                        $status = 'Image successfully uploaded!';
                        $fileName = $name;
                    }
                }


            $employee->Images                 = $fileName;
            $employee->save();


            }


           if(Config::get('module_config.payroll_module') == 1){


                    $salary_grade_master  = HrmSalaryGradeMaster::where('hrm_salary_grade_id', $request->salary_grade)->first(); 
                    $update_salary_master  = HrmEmployeeSalary::where('hrm_employee_job_info_id',$request->hrm_employee_job_info_id)->first();
                    $update_salary_master  = HrmEmployeeSalary::find($update_salary_master->id);
                    $update_salary_master->hrm_salary_grade_master_id = $salary_grade_master->id;
                    $update_salary_master->save();
            }



            DB::commit();    
            }catch (\Exception $e) {
                DB::rollback();
                // $validator->errors()->add('field', $e->getMessage());
                // return response()->json($validator->errors()->all()); 
                return response()->json(['errors'=>$validator->errors()->add('field', $e->getMessage())]);       
            } 

            // $request->session()->flash('alert-success', 'Data has been successfully updated!');        
            // return Redirect::to('employeejoin');         
    
            return response()->json(['success'=>'Record is successfully updated']);
    }












  function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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



    public function requestredflag(Request $request,$id)
    {


        $redflag_employee  = HrmRedflag::where('hrm_employee_id',$id)->first(); 

        if(empty($redflag_employee)) {     

            $insert = new HrmRedflag;
            $insert->hrm_employee_id  = $id;
            $insert->users_id         = Auth::user()->id;
            $insert->save();

         }else{
               DB::table('hrm_redflag')->where('hrm_employee_id', '=', $id)->delete();
         }   

                return response::json(array(
                    'success'    => true,
                    'messages'   => 'Successfully Updated'
                )); 

            // $request->session()->flash('alert-success', 'Data has been successfully updated!');        
            // return Redirect::to('employeejoin');         



    }



}
