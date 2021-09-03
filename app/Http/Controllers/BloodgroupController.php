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

use App\models\HrmBloodGroup;
class BloodgroupController extends Controller
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
        return view('bloodgroup.bloodgroup_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bloodgroup.create_bloodgroup');
    }

    public function bloodgrouplist(){
        return json_encode(array('data' => HrmBloodGroup::all()));
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
            'group_name'    => 'required|unique:hrm_blood_group,blood_group|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('bloodgroup/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $insert = new HrmBloodGroup;
        $insert->blood_group = $request->group_name;
        $insert->save();

        $request->session()->flash('alert-success', 'data has been successfully added!');        
        return Redirect::to('bloodgroup');   
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
        $bloodgroup      = HrmBloodGroup::find($id);
        
        if (empty($bloodgroup)){
            session()->flash('alert-danger', 'Invalid blood group !!');        
            return Redirect()->back();                          
        }

        return view('bloodgroup.edit_bloodgroup')->with('bloodgroup',$bloodgroup);
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
        $validator = Validator::make($request->all(), [
            // 'group_name'    => 'required|unique:hrm_blood_group,blood_group|max:255',
            'group_name'    => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $insert = HrmBloodGroup::find($id);
        $insert->blood_group = $request->group_name;
        $insert->save();

        $request->session()->flash('alert-success', 'successfully updated!');        
        return Redirect::to('bloodgroup');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @par

     am  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cancel(Request $request,$id){

        $cancel = HrmBloodGroup::find($id);

        if (empty($cancel)){
            session()->flash('alert-danger', 'Invalid blood group !!');        
            return Redirect()->back();              
        }

        $activity   = DB::table('hrm_employee')->where('hrm_blood_group_id','=',$id)->first();  

        if (!empty($activity)){
            session()->flash('alert-danger', "You can't delete this blood group !! This blood group use to employees ");        
            return Redirect()->back();              
        }

        DB::table('hrm_blood_group')->where('id', '=', $id)->delete();

        $request->session()->flash('alert-success', 'successfully deleted !');        
        return Redirect::to('bloodgroup');           

    }    
}
