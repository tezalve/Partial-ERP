<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Input;
use Validator;
use Redirect;
use Session;
use Crypt;
use Config;
use App\User;
use App\models\HrmUserLocation;
use App\models\Role;
use App\models\RoleUser;
use App\models\AssignedRoles;


class UsersController extends Controller
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
     
      return view('users.users_list');
    }




    public function userslocationlist(Request $request){
 
        $locationlist = DB::select("SELECT a.id,a.location_name,b.users_id,b.default_location FROM hrm_location a LEFT JOIN user_location b ON a.id=b.hrm_location_id AND a.valid=1 AND b.users_id=$request->user_id ");
        return json_encode(array('data' => $locationlist));       
    }


    public function users_list(){

        $userslists = DB::select("SELECT 
                                        a.id,
                                        a.name,
                                        a.email,
                                        c.location_name,
                                        GROUP_CONCAT(e.display_name) AS display_name,
                                        IF(a.valid = 1,'Active','Deactive') as status,
                                        a.valid
                                    FROM
                                        users a
                                            JOIN
                                        user_location b ON a.id = b.users_id
                                            AND b.default_location = 1
                                            JOIN
                                        hrm_location c ON b.hrm_location_id = c.id
                                            JOIN
                                        role_user d ON a.id = d.user_id
                                            JOIN
                                        roles e ON e.id = d.role_id
                                    GROUP BY a.id , a.name , a.email , c.location_name,a.valid");


        return json_encode(array('data' => $userslists));       
    }



    public function reset($id){

          $user_data= DB::SELECT("SELECT id,name,email,designation FROM users WHERE id=$id");
          return view('users.reset_password')
          ->with('user_data',$user_data);

          // return view('auth.passwords.reset');      
    }

    public function resetmypassword( ){
          $user_id=Auth::user()->id;
          
          $user_data= DB::SELECT("SELECT id,name,email,designation FROM users WHERE id=$user_id");
          return view('users.reset_password')
          ->with('user_data',$user_data);

          // return view('auth.passwords.reset');      
    }



    public function password_reset(Request $request){

        $validator = Validator::make($request->all(), [
            'password'          => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('users')
                        ->withErrors($validator)
                        ->withInput();
        }
         
         $bcrypt= bcrypt($request->password);
         
         DB::update("UPDATE users SET password = '$bcrypt' WHERE id = $request->user_id");
       

       $request->session()->flash('alert-success', 'data has been successfully updated!');        
       return Redirect::to('home'); 
          
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
      $role_lists = DB::select("SELECT id,display_name from roles"); 
       return view('users.create_users')
        ->with('role_list',$role_lists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
// dd($request->all());
       
        $validator = Validator::make($request->all(), [
            'username'          => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('users/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $check_data= DB::SELECT("SELECT id from users WHERE email='$request->email' AND valid=1");
        
        if(!empty($check_data)){
            return redirect('users/create');
        }


        DB::beginTransaction();
                    try{

                    //Create UserName

                            $userdata = User::create([
                                'name'              => $request->username,
                                'email'             => $request->email,
                                'designation'       => $request->designation,
                                'password'          => bcrypt($request->password),
                                'hrm_employee_id'   => $request->employee_name,

                            ]);
       
// dd($userdata);
                    //Create User Location
                            $count_row=count($request->permissionlocation);
                            
                            if (!empty($count_row)){

                                    foreach ($request->permissionlocation as $keys ) {

                                            $insert     = new HrmUserLocation;
                                            $insert->users_id          = $userdata->id;
                                            $insert->hrm_location_id   = $keys;
                                            $insert->default_location  = 0;
                                            $insert->save();
                                    }

                                   $defaultlocation=$request->defaultlocation[0];
                                   DB::update("UPDATE user_location SET default_location = 1 
                                                WHERE hrm_location_id = $defaultlocation and users_id=$userdata->id");


                                }else{
                                        return redirect('users/create'); 
                            }

                    //Create User Role

                            $roleuser= new RoleUser;
                            $roleuser->user_id         =$userdata->id;
                            $roleuser->role_id         =$request->userrole;                           
                            $roleuser->save();
// dd($userdata->id);


                            $insert = new AssignedRoles;
                            $insert->user_id = $userdata->id;
                            $insert->role_id = $request->userrole;
                            $insert->save();

        DB::commit();    
        }catch (\Exception $e) {
            DB::rollback();
            $validator->errors()->add('field', $e->getMessage());
            return response()->json($validator->errors()->all());        
        } 


       $request->session()->flash('alert-success', 'data has been successfully added!');        
       return Redirect::to('users'); 
        

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


        $userslists = DB::select("SELECT a.id,
            a.name,
            a.email,
            c.location_name,
            a.designation,
            e.display_name,
            e.id as User_role_id,
            f.id as employee_id,
            f.employee_name
            FROM users a 
            JOIN user_location  b on a.id=b.users_id AND b.default_location=1 AND a.id=$id
            JOIN hrm_location c On b.hrm_location_id=c.id 
            JOIN role_user d on a.id=d.user_id
            JOIN roles e on e.id=d.role_id
            LEFT JOIN hrm_employee f ON a.hrm_employee_id=f.id");

       
       $role_lists = DB::select("SELECT id,display_name from roles");
       

       return view('users.edit_users')
        ->with('role_list',$role_lists)
        ->with('edit_data',$userslists);
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
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'username'          => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('users')
                        ->withErrors($validator)
                        ->withInput();
        }

    // dd($request->all());

        DB::beginTransaction();
                    try{

                    DB::table('user_location')->where('users_id', '=', $request->user_id)->delete();  
                    DB::table('role_user')->where('user_id', '=', $request->user_id)->delete();
                    DB::table('assigned_roles')->where('user_id', '=', $request->user_id)->delete();


                    //Create User Location
                            $count_row=count($request->permissionlocation);
                            
                            if (!empty($count_row)){

                                    foreach ($request->permissionlocation as $keys ) {

                                            $insert     = new HrmUserLocation;
                                            $insert->users_id          = $request->user_id;
                                            $insert->hrm_location_id   = $keys;
                                            $insert->default_location  = 0;
                                            $insert->save();
                            }

                                   $defaultlocation=$request->defaultlocation[0];
                                   DB::update("UPDATE user_location SET default_location = 1 
                                                WHERE hrm_location_id = $defaultlocation and users_id=$request->user_id");


                                }else{
                                        return redirect('users/create'); 
                            }

                    //Create User Role

                            $roleuser= new RoleUser;
                            $roleuser->user_id         =$request->user_id;
                            $roleuser->role_id         =$request->userrole;
                           
                            $roleuser->save();


                            $insert = new AssignedRoles;
                            $insert->user_id = $request->user_id;
                            $insert->role_id = $request->userrole;
                            $insert->save();

// dd("noman");
                             if($request->employee_name==null){
                                $employee_id='null';
                             }else{
                                $employee_id=$request->employee_name;

                             } 

                            DB::update("UPDATE users SET designation =  '$request->designation',name= '$request->username',email='$request->email',hrm_employee_id=$employee_id WHERE id = $request->user_id");




        DB::commit();    
        }catch (\Exception $e) {
            DB::rollback();
            $validator->errors()->add('field', $e->getMessage());
            return response()->json($validator->errors()->all());        
        } 


       $request->session()->flash('alert-success', 'data has been successfully updated!');        
       return Redirect::to('users'); 
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




 public function cancel($id)
    {

        $password = bcrypt('zax!1%$l:)^'.$id);
        DB::update("UPDATE users SET valid = 0,password='$password' WHERE id = $id");

        // DB::table('user_location')->where('users_id', '=', $id)->delete();
        // DB::table('role_user')->where('user_id', '=', $id)->delete();
        // DB::table('assigned_roles')->where('user_id', '=', $id)->delete();
        // DB::table('users')->where('id', '=', $id)->delete();
        // dd("NOMAN");


       session()->flash('alert-success', 'data has been successfully deleted!');        
       return Redirect::to('users'); 
    }


 public function reactive($id)
    {

        DB::update("UPDATE users SET valid = 1 WHERE id = $id");

        // DB::table('user_location')->where('users_id', '=', $id)->delete();
        // DB::table('role_user')->where('user_id', '=', $id)->delete();
        // DB::table('assigned_roles')->where('user_id', '=', $id)->delete();
        // DB::table('users')->where('id', '=', $id)->delete();
        // dd("NOMAN");


       session()->flash('alert-success', 'data has been successfully deleted!');        
       return Redirect::to('users'); 
    }


//Role 


 public function role()
    {


       return view('users.role');
    }



    public function role_list(){

        $role_lists = DB::select("SELECT id,name,display_name,description from roles");
        return json_encode(array('data' => $role_lists));       
    }




  public function role_store(Request $request){

        
        
         $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'display_name'  => 'required',
            'description'   => 'required',
        ]);


        if ($validator->fails()) {
            return redirect('role')
                        ->withErrors($validator)
                        ->withInput();
        }

        $role= new Role;
        $role->name         =$request->name;
        $role->display_name =$request->display_name;
        $role->description  =$request->description;
        $role->save();

        $request->session()->flash('alert-success', 'data has been successfully added!');
        return redirect()->back();
    }



}
