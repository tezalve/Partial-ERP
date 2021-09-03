<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Input;
class MasterdataController extends Controller
{

    function __construct(){
        $this->middleware('auth');
    }  
    /**
    * get depertment
    * @return json           all depertment
    */
public function depertmentlist(Request $request){
    $depertment = [];
    if (!empty($request->term)){
    $depertment = DB::select("SELECT id,depertment_name as text FROM hrm_depertment
                            WHERE valid = 1 AND depertment_name LIKE '%$request->term%';");
    
    }else{
    $depertment = DB::select("SELECT id,depertment_name as text FROM hrm_depertment
                            WHERE valid = 1 AND depertment_name LIKE '%$request->term%';");
    }
    return response()->json($depertment);
}

public function religionlistdata(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,religion as text FROM hrm_religion
                            WHERE religion LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,religion as text FROM hrm_religion
                            WHERE  religion LIKE '%$request->term%';");
    }
        return response()->json($data);
}


public function maritalstatuslistdata(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,marital_status as text FROM hrm_marital_status
                            WHERE marital_status LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,marital_status as text FROM hrm_marital_status
                            WHERE  marital_status LIKE '%$request->term%';");
    }
        return response()->json($data);
}


public function bloodgrouplistdata(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,blood_group as text FROM hrm_blood_group
                            WHERE blood_group LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,blood_group as text FROM hrm_blood_group
                            WHERE  blood_group LIKE '%$request->term%';");
    }
        return response()->json($data);
}



public function designationlist(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,designation_name as text FROM hrm_designation
                            WHERE valid = 1 AND designation_name LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,designation_name as text FROM hrm_designation
                            WHERE valid = 1 AND designation_name LIKE '%$request->term%';");
    }
        return response()->json($data);
}



public function categorylist(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,category_name as text FROM hrm_category
                            WHERE valid = 1 AND category_name LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,category_name as text FROM hrm_category
                            WHERE valid = 1 AND category_name LIKE '%$request->term%';");
    }
        return response()->json($data);
}
public function shiftlist(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,shift_name as text FROM hrm_shift
                            WHERE valid = 1 AND shift_name LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,shift_name as text FROM hrm_shift
                            WHERE valid = 1 AND shift_name LIKE '%$request->term%';");
    }
        return response()->json($data);
}


public function loantypes_list(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,loan_type as text FROM hrm_loan_type
                            WHERE  loan_type LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,loan_type as text FROM hrm_loan_type
                            WHERE  loan_type LIKE '%$request->term%';");
    }
        return response()->json($data);
}



public function slap_name_list_data(Request $request){
    $data = [];
    $hrm_month_id  = $request->hrm_month_id;
    $year_id       = $request->year_id;
    if (!empty($request->term)){
    $data = DB::select("SELECT id,concat(slap_name,'  (',date_from,' to ',date_to,')') as text FROM hrm_salary_slap
                            WHERE hrm_month_id=$hrm_month_id AND year_id=$year_id AND slap_name LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,concat(slap_name,'  (',date_from,' to ',date_to,')') as text FROM hrm_salary_slap
                            WHERE hrm_month_id=$hrm_month_id AND year_id=$year_id AND slap_name LIKE '%$request->term%';");
    }
        return response()->json($data);
}

public function kpi_daterange_listdata(Request $request){
    $data = [];

    if (!empty($request->term)){
       $data = DB::select("SELECT id,description as text FROM hrm_kpi_assesment_year WHERE description LIKE '%$request->term%';");
    
    }else{
       $data = DB::select("SELECT id,description as text FROM hrm_kpi_assesment_year WHERE description LIKE '%$request->term%';");
    }
    return response()->json($data);
}


public function get_kpi_mark_list(Request $request){
    $data = [];

    if (!empty($request->term)){
       $data = DB::select("SELECT id,description as text FROM hrm_kpi_marks WHERE valid=1 AND description LIKE '%$request->term%';");
    
    }else{
       $data = DB::select("SELECT id,description as text FROM hrm_kpi_marks WHERE valid=1 AND description LIKE '%$request->term%';");
    }
    return response()->json($data);
}


public function get_bank_list(Request $request){
    $data = [];

    if (!empty($request->term)){
       $data = DB::select("SELECT id,bank_name as text FROM hrm_bank WHERE  bank_name LIKE '%$request->term%';");
    
    }else{
       $data = DB::select("SELECT id,bank_name as text FROM hrm_bank WHERE bank_name LIKE '%$request->term%';");
    }
    return response()->json($data);
}

public function kpi_assesment_date_list_data(Request $request){
    $data = [];

    if (!empty($request->term)){
       $data = DB::select("SELECT 
                                a.id,concat(b.description,' | ','From :',a.start_date,'  To :',a.end_date) as text
                            FROM
                                hrm_kpi_assesment_date a
                                    JOIN
                                hrm_kpi_assesment_year b ON b.id = a.hrm_kpi_assesment_year_id WHERE b.description LIKE '%$request->term%';");
    
    }else{
       $data = DB::select("SELECT 
                                a.id,concat(b.description,' | ','From :',a.start_date,'  To :',a.end_date) as text
                            FROM
                                hrm_kpi_assesment_date a
                                    JOIN
                                hrm_kpi_assesment_year b ON b.id = a.hrm_kpi_assesment_year_id WHERE b.description LIKE '%$request->term%';");
    }
    return response()->json($data);
}




public function kpi_task_department_listdata(Request $request){
    $data = [];

    if (!empty($request->term)){
       $data = DB::select("SELECT id,description as text FROM hrm_kpi_task_department WHERE valid=1 AND description LIKE '%$request->term%';");
    
    }else{
       $data = DB::select("SELECT id,description as text FROM hrm_kpi_task_department WHERE valid=1 AND description LIKE '%$request->term%';");
    }
    return response()->json($data);
}

public function department_listdata(Request $request){
    $data = [];
    if (!empty($request->term)){
       $data = DB::select("SELECT id, depertment_name as text FROM hrm_depertment");
    
    }else{
       $data = DB::select("SELECT id, depertment_name as text FROM hrm_depertment WHERE depertment_name LIKE '%$request->term%';");
    }
    return response()->json($data);
}


public function salary_master_listdata(Request $request){
    $data = [];
    $hrm_month_id       = $request->hrm_month_id;
    $year_id            = $request->year_id;
    $hrm_location_id    = $request->hrm_location_id;
    $status             = $request->status;

    if (!empty($request->term)){
    $data = DB::select("SELECT id,declaration_date as text FROM hrm_salary_generate_master
                            WHERE status=$status AND hrm_month_id=$hrm_month_id AND year_id=$year_id AND hrm_location_id=$hrm_location_id AND valid=1 AND declaration_date LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,declaration_date as text FROM hrm_salary_generate_master
                            WHERE status=$status AND hrm_month_id=$hrm_month_id AND year_id=$year_id AND hrm_location_id=$hrm_location_id AND valid=1 AND declaration_date LIKE '%$request->term%';");
    }
        return response()->json($data);
}



public function employeelist(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,concat(employee_name, ' | ' ,IFNull(contact_number,'N/A'))as text FROM hrm_employee
                            WHERE active_status=1 and  employee_name LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT id,concat(employee_name, ' | ' ,IFNull(contact_number,'N/A')) as text FROM hrm_employee
                            WHERE active_status=1 and employee_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}

public function holiday_list_data(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,concat(holiday_name, ' | ' ,holiday_description) text FROM hrm_holiday
                            WHERE   holiday_name LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT id,concat(holiday_name, ' | ' ,holiday_description) text FROM hrm_holiday
                            WHERE   holiday_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}

public function salaryheadgrouplist(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,concat(group_name, ' | ' ,IF((generate_type=1),'Addition','Deduction') ) text FROM hrm_salary_head_group
                            WHERE   group_name LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT id,concat(group_name, ' | ' ,IF((generate_type=1),'Addition','Deduction')) text FROM hrm_salary_head_group
                            WHERE   group_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}

public function salarygrade_list(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,grade_name text FROM hrm_salary_grade
                            WHERE  valid=1 and  grade_name LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT id,grade_name text FROM hrm_salary_grade
                            WHERE  valid=1 and  grade_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}



public function salary_head_list(Request $request){
    $data = [];

    $condition = '';
    if (!empty($request->fb)){
         $condition = ' AND a.apply_for=2 ';
    }




    if (!empty($request->term)){
    $data = DB::select("SELECT a.id,concat(a.salary_head,' || ',if(b.generate_type = 1,'Addition','Deduction')) text FROM   hrm_salary_head a
                            JOIN hrm_salary_head_group b ON a.hrm_salary_head_group_id = b.id
                            AND  a.active_status=1 $condition and  a.salary_head LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT a.id,concat(a.salary_head,' || ',if(b.generate_type = 1,'Addition','Deduction')) text FROM hrm_salary_head a
                            JOIN hrm_salary_head_group b ON a.hrm_salary_head_group_id = b.id
                            AND  a.active_status=1 $condition and  a.salary_head LIKE '%$request->term%' ;");

    }
        return response()->json($data);
}

public function shiftrole_list_data(Request $request){
    $data = [];
    $user_id    = Auth::user()->id;

    if (!empty($request->term)){
    $data = DB::select("SELECT a.id,concat(a.shift_role_name, ' | ' ,b.location_name) as  text,b.id as location_id FROM  hrm_shift_role a JOIN hrm_location b ON a.hrm_location_id=b.id JOIN user_location c ON b.id = c.hrm_location_id AND c.users_id = $user_id
        WHERE a.shift_role_name  LIKE '%$request->term%' ;");
    
    }else{
   $data = DB::select("SELECT a.id,concat(a.shift_role_name, ' | ' ,b.location_name) as  text,b.id as location_id FROM  hrm_shift_role a JOIN hrm_location b ON a.hrm_location_id=b.id JOIN user_location c ON b.id = c.hrm_location_id AND c.users_id = $user_id
       WHERE a.shift_role_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}

public function file_type_list(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,file_type_name text FROM hrm_file_type
                            WHERE    file_type_name LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT id,file_type_name text FROM hrm_file_type
                            WHERE   file_type_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}



public function bonus_name_list(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,bonus_name text FROM hrm_bonus
                            WHERE    bonus_name LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT id,bonus_name text FROM hrm_bonus
                            WHERE   bonus_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}



public function plantname_list_data(Request $request){

    $user_id    = Auth::user()->id;
    $data       = [];
    $condition  = "";
    
    // if (!empty($request->term)){
    //     $data = DB::select("SELECT a.id,a.plant_name as text FROM hrm_plant a LEFT JOIN hrm_location b ON a.hrm_location_id=b.id 
    //         JOIN user_location c ON b.id = c.hrm_location_id AND c.users_id = $user_id AND a.valid=1
    //         WHERE a.plant_name LIKE '%$request->term%' ;");

    // }else{
    //     $data = DB::select("SELECT a.id,a.plant_name as text  FROM hrm_plant a LEFT JOIN hrm_location b ON a.hrm_location_id=b.id 
    //         JOIN user_location c ON b.id = c.hrm_location_id AND c.users_id = $user_id AND a.valid=1
    //         WHERE a.plant_name LIKE '%$request->term%' ;");
    // }

    // if($request->location != 0){
    //     $condition = " AND a.hrm_location_id = ".$request->location;
    // }

    $plant_list = DB::SELECT("SELECT a.id,
                            a.plant_name AS text
                            FROM hrm_plant a WHERE a.hrm_location_id is null
                            UNION
                            SELECT a.id,
                            a.plant_name AS text
                            FROM hrm_plant a 
                            JOIN hrm_location b ON a.hrm_location_id=b.id AND a.valid=1
                            JOIN user_location c ON b.id = c.hrm_location_id AND c.users_id = $user_id WHERE a.plant_name LIKE '%$request->term%' ;");    
    return response()->json($plant_list);
}



public function education_list_data(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,education_name as text FROM hrm_education
                            WHERE    education_name LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT id,education_name as text FROM hrm_education
                            WHERE   education_name LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}






public function salary_head_loan_list(Request $request){
    $data = [];

    if (!empty($request->term)){
    $data = DB::select("SELECT a.id,concat(a.salary_head,' || ',if(b.generate_type = 1,'Addition','Deduction')) as text FROM hrm_salary_head a JOIN hrm_salary_head_group b ON b.id=a.hrm_salary_head_group_id AND b.group_status=3 AND a.active_status=1  AND  a.salary_head LIKE '%$request->term%' ;");
    
    }else{
    $data = DB::select("SELECT a.id,concat(a.salary_head,' || ',if(b.generate_type = 1,'Addition','Deduction')) as text FROM hrm_salary_head a JOIN hrm_salary_head_group b ON b.id=a.hrm_salary_head_group_id AND b.group_status=3 AND a.active_status=1  AND  a.salary_head LIKE '%$request->term%' ;");
    }
        return response()->json($data);
}

 


public function joinemployeelist(Request $request){


    $apply_old_info = $request->apply_old_info;
    $data           = [];
    $user_id        = Auth::user()->id;

    if ($apply_old_info==1){
        $condition ="AND b.id in   (SELECT id FROM  hrm_employee_job_info
                                    WHERE id in (SELECT max(id) FROM hrm_employee_job_info 
                                    Group By hrm_employee_id) )";
    }else{
        $condition ="AND b.employee_activity=1 AND a.active_status=1";
    }



    if (isset($request->location)){
        $condition= $condition." AND b.hrm_location_id=".$request->location;
    }

    if (!empty($request->term)){
            $data = DB::select("SELECT a.id,concat(a.employee_name, ' | ' ,b.employee_code,' | ',c.alis,' | ',a.contact_number) as text,d.depertment_name,c.designation_name,f.shift_name,b.employee_code
                                    FROM hrm_employee a 
                                    JOIN hrm_employee_job_info b  On a.id=b.hrm_employee_id
                                    $condition
                                    JOIN hrm_designation c On b.hrm_designation_id=c.id
                                    JOIN hrm_depertment  d On b.hrm_depertment_id=d.id
                                    JOIN hrm_employee_shift e On e.hrm_employee_job_info_id=b.id
                                    AND e.id in (SELECT max(id) FROM hrm_employee_shift WHERE hrm_employee_job_info_id=b.id) 
                                    JOIN hrm_shift f On e.hrm_shift_id=f.id
                                    JOIN user_location g ON b.hrm_location_id = g.hrm_location_id AND g.users_id = $user_id
                                    WHERE  a.employee_name  LIKE '%$request->term%' OR b.employee_code LIKE '%$request->term%' ;");   
    }else{

          $data = DB::select("SELECT a.id,concat(a.employee_name, ' | ' ,b.employee_code,' | ',c.alis,' | ',a.contact_number) as text,d.depertment_name,c.designation_name,f.shift_name,b.employee_code
                                    FROM hrm_employee a 
                                    JOIN hrm_employee_job_info b  On a.id=b.hrm_employee_id
                                    $condition
                                    JOIN hrm_designation c On b.hrm_designation_id=c.id
                                    JOIN hrm_depertment  d On b.hrm_depertment_id=d.id
                                    JOIN hrm_employee_shift e On e.hrm_employee_job_info_id=b.id
                                    AND e.id in (SELECT max(id) FROM hrm_employee_shift WHERE hrm_employee_job_info_id=b.id) 
                                    JOIN hrm_shift f On e.hrm_shift_id=f.id
                                    JOIN user_location g ON b.hrm_location_id = g.hrm_location_id AND g.users_id = $user_id
                                    WHERE  a.employee_name  LIKE '%$request->term%' OR b.employee_code LIKE '%$request->term%' ;");     
    }
    return response()->json($data);
}



public function joinemployeelist_accounts(Request $request){
    $data       = [];
    $user_id    = Auth::user()->id;
    if (!empty($request->term)){
        $data = DB::select("SELECT a.id,concat(a.employee_name, ' | ' ,IFNull(bb.accounts_code,'N/A'),' | ',c.alis,' | ',a.contact_number, ' | ' ,b.employee_code) as text,d.depertment_name,c.designation_name,f.shift_name,b.employee_code
                            FROM hrm_employee a 
                            JOIN hrm_employee_job_info b  On a.id=b.hrm_employee_id AND a.active_status=1 and b.employee_activity=1
                            JOIN hrm_employee_salary bb ON b.id=bb.hrm_employee_job_info_id 
                            JOIN hrm_designation c On b.hrm_designation_id=c.id
                            JOIN hrm_depertment  d On b.hrm_depertment_id=d.id
                            JOIN hrm_employee_shift e On e.hrm_employee_job_info_id=b.id
                            JOIN hrm_shift f On e.hrm_shift_id=f.id
                            JOIN user_location g ON b.hrm_location_id = g.hrm_location_id AND g.users_id = $user_id
                            AND e.id in (SELECT max(id) FROM hrm_employee_shift WHERE hrm_employee_job_info_id=b.id)
                            WHERE  a.employee_name  LIKE '%$request->term%' OR b.employee_code LIKE '%$request->term%' OR bb.accounts_code LIKE '%$request->term%' ;");

    }else{


        $data = DB::select("SELECT a.id,concat(a.employee_name, ' | ' ,IFNull(bb.accounts_code,'N/A'),' | ',c.alis,' | ',a.contact_number, ' | ' ,b.employee_code) as text,d.depertment_name,c.designation_name,f.shift_name,b.employee_code
                            FROM hrm_employee a 
                            JOIN hrm_employee_job_info b  On a.id=b.hrm_employee_id AND a.active_status=1 and b.employee_activity=1
                            JOIN hrm_employee_salary bb ON b.id=bb.hrm_employee_job_info_id   
                            JOIN hrm_designation c On b.hrm_designation_id=c.id
                            JOIN hrm_depertment  d On b.hrm_depertment_id=d.id
                            JOIN hrm_employee_shift e On e.hrm_employee_job_info_id=b.id
                            JOIN hrm_shift f On e.hrm_shift_id=f.id
                            JOIN user_location g ON b.hrm_location_id = g.hrm_location_id AND g.users_id = $user_id
                            AND e.id in (SELECT max(id) FROM hrm_employee_shift WHERE hrm_employee_job_info_id=b.id) 
                            WHERE b.employee_code LIKE '%$request->term%' OR a.employee_name  LIKE '%$request->term%' OR bb.accounts_code  LIKE '%$request->term%';");    
    }
    return response()->json($data);
}


 


public function getemployeejobinfo_details(Request $request){
    $data       = [];
    $user_id    = Auth::user()->id;
    
    if (!empty($request->term)){
        $data = DB::select("SELECT a.id,concat(a.employee_name, ' | ' ,b.employee_code,' | ',e.alis,' | ',a.contact_number) as text,
                                c.location_name,
                                b.id as hrm_employee_job_info_id,
                                d.depertment_name,
                                d.id as department_id,
                                e.designation_name,
                                b.basic_salary,
                                f.joining_date,
                                f.confirmation_date,
                                g.employment_status as employeestatus_name,
                                h.category_name,
                                i.section_name,
                                b.overtime_status,
                                j.employee_name as manage_by_name,
                                l.shift_name,
                                b.employee_code,
                                b.insurance 
                                from hrm_employee a 
                                JOIN hrm_employee_job_info b on a.id=b.hrm_employee_id and a.active_status=1 and b.employee_activity=1  
                                Join hrm_location c On b.hrm_location_id=c.id 
                                JOIN hrm_depertment d On b.hrm_depertment_id=d.id 
                                Join hrm_designation e On b.hrm_designation_id=e.id 
                                Join hrm_employee_joining f on b.hrm_employee_id=f.hrm_employee_id
                                Join hrm_employment_status g On b.hrm_employment_status_id=g.id
                                Join hrm_category h on b.hrm_category_id=h.id
                                Join hrm_section i on b.hrm_section_id=i.id
                                join hrm_employee j on b.hrm_manage_by_id=j.id
                                Join hrm_employee_shift k on b.id=k.hrm_employee_job_info_id AND  k.id in (SELECT max(id) FROM hrm_employee_shift WHERE hrm_employee_job_info_id=b.id)
                                Join hrm_shift l on k.hrm_shift_id=l.id
                                JOIN user_location m ON b.hrm_location_id = m.hrm_location_id AND m.users_id = $user_id
                                WHERE  a.employee_name  LIKE '%$request->term%' OR b.employee_code LIKE '%$request->term%' ;");

    }else{
        
        $data = DB::select("SELECT a.id,concat(a.employee_name, ' | ' ,b.employee_code,' | ',e.alis,' | ',a.contact_number)  as text,
                                c.location_name,
                                b.id as hrm_employee_job_info_id,
                                d.depertment_name,
                                d.id as department_id,
                                e.designation_name,
                                b.basic_salary,
                                f.joining_date,
                                f.confirmation_date,
                                g.employment_status as employeestatus_name,
                                h.category_name,
                                i.section_name,
                                b.overtime_status,
                                j.employee_name as manage_by_name,
                                l.shift_name,
                                b.employee_code,
                                b.insurance 
                                from hrm_employee a 
                                JOIN hrm_employee_job_info b on a.id=b.hrm_employee_id and a.active_status=1 and b.employee_activity=1  
                                Join hrm_location c On b.hrm_location_id=c.id 
                                JOIN hrm_depertment d On b.hrm_depertment_id=d.id 
                                Join hrm_designation e On b.hrm_designation_id=e.id 
                                Join hrm_employee_joining f on b.hrm_employee_id=f.hrm_employee_id
                                Join hrm_employment_status g On b.hrm_employment_status_id=g.id
                                Join hrm_category h on b.hrm_category_id=h.id
                                Join hrm_section i on b.hrm_section_id=i.id
                                join hrm_employee j on b.hrm_manage_by_id=j.id
                                Join hrm_employee_shift k on b.id=k.hrm_employee_job_info_id AND k.id in (SELECT max(id) FROM hrm_employee_shift WHERE hrm_employee_job_info_id=b.id)
                                Join hrm_shift l on k.hrm_shift_id=l.id
                                JOIN user_location m ON b.hrm_location_id = m.hrm_location_id AND m.users_id = $user_id
                                WHERE  a.employee_name  LIKE '%$request->term%' OR b.employee_code LIKE '%$request->term%' ;");    
    }
    return response()->json($data);
}



public function employeestatuslist(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,employment_status as text FROM hrm_employment_status
                            WHERE employment_status LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,employment_status as text FROM hrm_employment_status
                            WHERE employment_status LIKE '%$request->term%';");
    }
        return response()->json($data);
}


public function locationlist(Request $request){
    $data = [];
    $user_id    = Auth::user()->id;

    if (!empty($request->term)){
    $data = DB::select("SELECT a.id,a.location_name as text,c.short_description,c.id as hrm_device_information_id FROM hrm_location a  
                        JOIN user_location b ON a.id = b.hrm_location_id AND b.users_id = $user_id
                        LEFT JOIN hrm_device_information c ON a.hrm_device_information_id=c.id
                        WHERE a.valid = 1 AND a.location_name LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT a.id,a.location_name as text,c.short_description,c.id as hrm_device_information_id   FROM hrm_location a  
                        JOIN user_location b ON a.id = b.hrm_location_id AND b.users_id = $user_id
                        LEFT JOIN hrm_device_information c ON a.hrm_device_information_id=c.id
                        WHERE a.valid = 1 ;");
    }
        return response()->json($data);
}

public function locationlistdataall(Request $request){
    $data = [];

    if (!empty($request->term)){
    $data = DB::select("SELECT id,location_name as text FROM hrm_location   
                        WHERE valid = 1 AND location_name LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,location_name as text FROM hrm_location   
                        WHERE valid = 1 AND location_name LIKE '%$request->term%';");
    }
        return response()->json($data);
}



public function sectionlist(Request $request){
    $data = [];
    if (!empty($request->term)){
    $data = DB::select("SELECT id,section_name as text FROM hrm_section
                            WHERE section_name LIKE '%$request->term%';");
    
    }else{
    $data = DB::select("SELECT id,section_name as text FROM hrm_section
                            WHERE section_name LIKE '%$request->term%';");
    }
        return response()->json($data);
}



    public function leavetypelist(Request $request){
    $data = [];
        if (!empty($request->term)){
            $data = DB::select("SELECT id,leave_type as text FROM hrm_employee_leave_type
            WHERE valid=1 And leave_type LIKE '%$request->term%';");

        }else{
             $data = DB::select("SELECT id,leave_type as text FROM hrm_employee_leave_type
            WHERE  valid=1 And leave_type LIKE '%$request->term%';");
        }
    return response()->json($data);
    }


    // public function leavetypelist(Request $request){
    // $data = [];
    //     if (!empty($request->term)){
    //         $data = DB::select("SELECT id,concat(leave_type, ' || ' , IF(leave_status=1,'Company Policy','Holiday Against Leave')) as text FROM hrm_employee_leave_type
    //         WHERE valid=1 And leave_type LIKE '%$request->term%';");

    //     }else{
    //          $data = DB::select("SELECT id,concat(leave_type, ' || ' , IF(leave_status=1,'Company Policy','Holiday Against Leave')) as text FROM hrm_employee_leave_type
    //         WHERE  valid=1 And leave_type LIKE '%$request->term%';");
    //     }
    // return response()->json($data);
    // }


public function monthlist(Request $request){
    $data = [];
        if (!empty($request->term)){
        $data = DB::select("SELECT id,month_name as text FROM hrm_month
        WHERE month_name LIKE '%$request->term%';");

        }else{
        $data = DB::select("SELECT id,month_name as text FROM hrm_month
        WHERE month_name LIKE '%$request->term%';");
        }
        return response()->json($data);
    }



public function userlist(Request $request){
    $data = [];
        if (!empty($request->term)){
        $data = DB::select("SELECT id,concat(name, ' | ' ,email) as text FROM users
        WHERE name LIKE '%$request->term%';");

        }else{
        $data = DB::select("SELECT id,concat(name, ' | ' ,email) as text FROM users
        WHERE name LIKE '%$request->term%';");
        }
        return response()->json($data);
    }




  public function getDesignationByEmployeeName(Request $request){

// dd($request);
        $term                    = Input::get('term');
        $acc_reference_type_id   = Input::get('acc_reference_type_id');
        $data = DB::select("SELECT id,reference_name  text FROM acc_reference_info WHERE valid = 1 AND acc_reference_type_id = $acc_reference_type_id AND reference_name LIKE '%$term%' ");
        return response()->json($data);
    }




public function plantwithsection_list_data(Request $request){
    
        $data         = [];
        $user_id      = Auth::user()->id;
        $hrm_plant_id = $request->hrm_plant_id;

        if (!empty($request->term)){

            $data = DB::select("SELECT 
                                        a.id,
                                        CONCAT(b.plant_name,' -- ',d.section_name) as  text
                                        
                                    FROM
                                        hrm_plant_with_section a
                                            JOIN
                                        hrm_plant b ON a.hrm_plant_id = b.id AND a.valid = 1
                                            AND b.valid = 1 AND b.id=$hrm_plant_id
                                            JOIN
                                        hrm_location c ON b.hrm_location_id = c.id AND c.valid = 1
                                            JOIN
                                        hrm_section d ON a.hrm_section_id=d.id
                                            JOIN
                                        user_location e ON c.id = e.hrm_location_id
                                            AND e.users_id = $user_id
                                         WHERE  b.plant_name  LIKE '%$request->term%' OR d.section_name LIKE '%$request->term%'");

        }else{

            $data = DB::select("SELECT 
                                        a.id,
                                        CONCAT(b.plant_name,' -- ',d.section_name) as  text
                                        
                                    FROM
                                        hrm_plant_with_section a
                                            JOIN
                                        hrm_plant b ON a.hrm_plant_id = b.id AND a.valid = 1
                                            AND b.valid = 1 AND b.id=$hrm_plant_id
                                            JOIN
                                        hrm_location c ON b.hrm_location_id = c.id AND c.valid = 1
                                            JOIN
                                        hrm_section d ON a.hrm_section_id=d.id
                                            JOIN
                                        user_location e ON c.id = e.hrm_location_id
                                            AND e.users_id = $user_id");


        }

        return response()->json($data);
    }




public function increment_range_list_data(Request $request){
    
        $data  = [];
        $hrm_kpi_assesment_date_id = $request->hrm_kpi_assesment_date_id;

        $data = DB::select("SELECT 
                                    aa.id,
                                    CONCAT(aa.increment_amounts,
                                            ' ',
                                            aa.entry_statuss,
                                            ' | ',
                                            aa.number_range) AS text
                                FROM
                                    (SELECT 
                                        a.id,
                                            CONCAT(a.number_from, '-', a.number_to) AS number_range,
                                            IF(a.entry_status = 1, CONCAT(a.increment_amount, IF(a.increment_amount_type = 1, '%', 'Tk.')), 'Promoted') AS increment_amounts,
                                            IF(a.entry_status = 1, 'Increment', 'Promotion') AS entry_statuss,
                                            CONCAT(c.description, ' | ', 'From :', b.start_date, '  To :', b.end_date) AS date_year,
                                            b.id AS hrm_kpi_assesment_date_id
                                    FROM
                                        hrm_kpi_increment_range a
                                    JOIN hrm_kpi_assesment_date b ON b.id = a.hrm_kpi_assesment_date_id
                                        AND a.valid = 1
                                    JOIN hrm_kpi_assesment_year c ON b.hrm_kpi_assesment_year_id = c.id) aa WHERE aa.hrm_kpi_assesment_date_id=$hrm_kpi_assesment_date_id");
    

        return response()->json($data);
    }


}