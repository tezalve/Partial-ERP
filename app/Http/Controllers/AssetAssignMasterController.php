<?php

namespace App\Http\Controllers;

use App\models\{ HrmAssetStoreMaster, HrmAssetStoreLedger,HrmAssetAssignMaster, HrmAssetAssignLedger};
use Illuminate\Http\Request;
use DB;
use Validator;
use Response;

class AssetAssignMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('assetassign.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assetassign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            "hrm_employee_id" => 'required',
            "hrm_asset_store_master_id" => 'required',
            "product_id" => 'required',
            "price" => 'required',
            "serial_no" => 'required'
        ]);

        if( $validator->fails() ){
            return response::json(array(
                'success'   => false,
                'message'  => 'Failure, validation fail!'
            ));
        } 
       
        DB::beginTransaction();
        try {

            $asset_master = new HrmAssetStoreMaster;
            $asset_master->transaction_type = 2;
            $asset_master->store_no='sdsd';
            $asset_master->users_id = auth()->user()->id;
            $asset_master->save();

            $asset_assign_master = new HrmAssetAssignMaster;
            $asset_assign_master->hrm_employee_id = $request->hrm_employee_id;
            $asset_assign_master->hrm_asset_store_master_id = $asset_master->id;
            $asset_assign_master->users_id = auth()->user()->id;
            $asset_assign_master->save();
            
            $asset_assign_ledger = new HrmAssetAssignLedger;
            $asset_assign_ledger->asset_assign_master_id = $asset_assign_master->id;
            $asset_assign_ledger->product_id = $request->product_id;
            $asset_assign_ledger->price = $request->price;
            $asset_assign_ledger->serial_no = $request->serial_no;
            $asset_assign_ledger->qty_stockout = 1;
            $asset_assign_ledger->save();
           
            $asset_ledger = new HrmAssetStoreLedger;
            $asset_ledger->asset_store_master_id = $asset_master->id;
            $asset_ledger->product_id = $request->product_id;
            $asset_ledger->price =  $request->price;
            $asset_ledger->serial_no = $request->serial_no;
            $asset_ledger->qty_stockout = 1;
            $asset_ledger->qty_stockin=0;
            $asset_ledger->hrm_asset_store_ledger_id=$request->asset_store_ledger_id;
            $asset_ledger->save();
         
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response::json(array(
                'success'   => false,
                'message'   => 'Failure!'
            ));
        }

        return response::json(array(
            'success'   => true,
            'message'   => 'Success!'
         ));
        
        // return redirect()->route('assetassign.index')->with('success', 'Successfully assigned!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\HrmAssetAssignMaster  $hrmAssetAssignMaster
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAssetAssignMaster $hrmAssetAssignMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\HrmAssetAssignMaster  $hrmAssetAssignMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = DB::select
        ("SELECT 
            a.id,
            CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model, ' | ', b.serial_no) as asset,
            CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', j.designation_name, ' | ', i.depertment_name, ' | ', h.location_name) as employee_name,
            f.id as employee_id,
            bb.id as ledger_id,
            c.id as hrm_asset_id,
            i.depertment_name as department,
            j.designation_name as designation,
            bb.price as price,
            bb.serial_no as serial_no
        FROM
            hrm_asset_assign_master as a
        JOIN
            hrm_asset_assign_ledger AS b ON a.id = b.asset_assign_master_id AND a.is_valid = 1 AND b.is_valid=1
            AND a.id=$id
        JOIN
            hrm_asset_store_master aa ON aa.id=a.hrm_asset_store_master_id AND aa.is_valid=1
        JOIN
            hrm_asset_store_ledger bb ON aa.id=bb.asset_store_master_id AND bb.is_valid=1
        JOIN
            hrm_asset as c ON c.id = b.product_id
        JOIN
            hrm_asset_type as d ON d.id = c.asset_type_id
        JOIN
            hrm_asset_brand as e ON e.id = c.brand_id
        JOIN
            hrm_employee as f ON f.id = a.hrm_employee_id
        JOIN 
            hrm_employee_job_info g ON f.id=g.hrm_employee_id AND  f.active_status=1 AND g.employee_activity=1
        JOIN 
            hrm_location h On g.hrm_location_id=h.id 
        JOIN
            hrm_depertment i On g.hrm_depertment_id=i.id 
        JOIN 
            hrm_designation j On g.hrm_designation_id=j.id");
            
        return view('assetassign.edit', compact('data','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\HrmAssetAssignMaster  $hrmAssetAssignMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        // dd($request->all());
        $activity = DB::table('hrm_asset_assign_master')->where('is_valid','=',0)
            ->where('id','=',$id)->first();  
            // dd($activity);
        
        if (!empty($activity)){
                return response::json(array(
                    'success'   => false,
                    'messages'  => 'This data already updated, Please check!',
                ));
        }
        
        $find_data = DB::table('hrm_asset_assign_master')->where('id','=',$id)->first();
        
        // dd($find_data);

        DB::beginTransaction();
        try {
            HrmAssetStoreMaster::where('id',$find_data->hrm_asset_store_master_id)->update(['is_valid' => 0]);
            HrmAssetStoreLedger::where('asset_store_master_id',$find_data->hrm_asset_store_master_id)->update(['is_valid' => 0]);
            HrmAssetAssignMaster::where('id',$id)->update(['is_valid' => 0]);
            HrmAssetAssignLedger::where('asset_assign_master_id',$id)->update(['is_valid' => 0]);
            
            $asset_master = new HrmAssetStoreMaster;
            $asset_master->transaction_type = 2;
            $asset_master->store_no='sdsd';
            $asset_master->users_id = auth()->user()->id;
            $asset_master->save();

            $asset_ledger = new HrmAssetStoreLedger;
            $asset_ledger->asset_store_master_id = $asset_master->id;
            $asset_ledger->product_id = $request->product_id;
            $asset_ledger->price =  $request->price;
            $asset_ledger->serial_no = $request->serial_no;
            $asset_ledger->qty_stockout = 1;
            $asset_ledger->qty_stockin=0;
            $asset_ledger->hrm_asset_store_ledger_id=$request->asset_store_ledger_id;
            $asset_ledger->save();


            $asset_assign_master = new HrmAssetAssignMaster;
            $asset_assign_master->hrm_employee_id = $request->hrm_employee_id;
            $asset_assign_master->hrm_asset_store_master_id = $asset_master->id;
            $asset_assign_master->users_id = auth()->user()->id;
            $asset_assign_master->save();
            
            $asset_assign_ledger = new HrmAssetAssignLedger;
            $asset_assign_ledger->asset_assign_master_id = $asset_assign_master->id;
            $asset_assign_ledger->product_id = $request->product_id;
            $asset_assign_ledger->price = $request->price;
            $asset_assign_ledger->serial_no = $request->serial_no;
            $asset_assign_ledger->qty_stockout = 1;
            $asset_assign_ledger->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response::json(array(
                'success'   => false,
                'message'   => 'Failure!'
            ));
        }
        return response::json(array(
            'success'   => true,
            'message'   => 'Success!'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\HrmAssetAssignMaster  $hrmAssetAssignMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmAssetAssignMaster $hrmAssetAssignMaster)
    {
        //
    }

    public function asset_assign_list()
    {
        $asset_assign_list = DB::select
        ("SELECT 
            a.id,
            CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model, ' | ', b.serial_no, ' | ', c.description) as asset,
            CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', j.designation_name, ' | ', i.depertment_name, ' | ', h.location_name) as employee,
            f.Images,
            a.created_at,
            a.hrm_employee_id as employee_id,
            b.product_id as product_id
        FROM
            hrm_asset_assign_master as a
        JOIN
            hrm_asset_assign_ledger AS b ON a.id = b.asset_assign_master_id
        JOIN
            hrm_asset as c ON c.id = b.product_id
        JOIN
            hrm_asset_type as d ON d.id = c.asset_type_id
        JOIN
            hrm_asset_brand as e ON e.id = c.brand_id
        JOIN
            hrm_employee as f ON f.id = a.hrm_employee_id
        JOIN 
            hrm_employee_job_info g ON f.id=g.hrm_employee_id AND  f.active_status=1 AND g.employee_activity=1
        JOIN 
            hrm_location h On g.hrm_location_id=h.id 
        JOIN
            hrm_depertment i On g.hrm_depertment_id=i.id 
        JOIN 
            hrm_designation j On g.hrm_designation_id=j.id
        WHERE
            a.is_valid = 1 AND b.is_valid = 1 AND a.status = 1");

        return json_encode(array('data' => $asset_assign_list));
    }

    public function asset_assign_list_inactive()
    {
        $asset_assign_list = DB::select(DB::raw(
        "SELECT 
            a.id,
            CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model, ' | ', b.serial_no, ' | ', c.description) as asset,
            CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', j.designation_name, ' | ', i.depertment_name, ' | ', h.location_name) as employee,
            f.Images,
            a.created_at,
            a.hrm_employee_id as employee_id,
            b.product_id as product_id,
            CASE
                WHEN a.status = 2 THEN 'Reuse'
                WHEN a.status = 3 THEN 'Reject'
                Else 'dono'
            END AS statustext
        FROM
            hrm_asset_assign_master as a
        JOIN
            hrm_asset_assign_ledger AS b ON a.id = b.asset_assign_master_id
        JOIN
            hrm_asset as c ON c.id = b.product_id
        JOIN
            hrm_asset_type as d ON d.id = c.asset_type_id
        JOIN
            hrm_asset_brand as e ON e.id = c.brand_id
        JOIN
            hrm_employee as f ON f.id = a.hrm_employee_id
        JOIN 
            hrm_employee_job_info g ON f.id=g.hrm_employee_id AND  f.active_status=1 AND g.employee_activity=1
        JOIN 
            hrm_location h On g.hrm_location_id=h.id 
        JOIN
            hrm_depertment i On g.hrm_depertment_id=i.id 
        JOIN 
            hrm_designation j On g.hrm_designation_id=j.id
        WHERE
            a.is_valid = 1 AND b.is_valid = 1 AND a.status != 1
        "));

        return json_encode(array('data' => $asset_assign_list));
    }

    public function asset_data(Request $request){
        $data = [];
        if (!empty($request->term)){
            $data = DB::select("SELECT 
                                    d.hrm_asset_store_ledger_id AS id,
                                    CONCAT(c.asset_type_name,
                                            ' | ',
                                            b.brand_name,
                                            ' | ',
                                            a.model,
                                            ' | ',
                                            d.serial_no,
                                            ' | ',
                                            a.description ) AS text,
                                    d.price,
                                    d.product_id,
                                    d.serial_no
                                FROM
                                    hrm_asset a
                                JOIN
                                    hrm_asset_brand AS b ON b.id = a.brand_id
                                JOIN
                                    hrm_asset_type AS c ON c.id = a.asset_type_id
                                JOIN
                                    hrm_asset_store_ledger AS d ON d.product_id = a.id
                                WHERE
                                    d.is_valid = 1
                                    AND
                                    c.asset_type_name LIKE '%$request->term%'
                                    OR
                                    b.brand_name LIKE '%$request->term%'
                                    OR
                                    a.model LIKE '%$request->term%'
                                    OR
                                    d.serial_no LIKE '%$request->term%'
                                    OR
                                    a.description LIKE '%$request->term%'
                                GROUP BY 
                                    d.product_id , d.serial_no , d.hrm_asset_store_ledger_id, c.asset_type_name,b.brand_name,a.model,d.price
                                HAVING 
                                    SUM(d.qty_stockin - d.qty_stockout) > 0");
        
        }else{

            $data = DB::select("SELECT
                                    d.hrm_asset_store_ledger_id AS id,
                                    CONCAT(c.asset_type_name,
                                            ' | ',
                                            b.brand_name,
                                            ' | ',
                                            a.model,
                                            ' | ',
                                            d.serial_no,
                                            ' | ',
                                            a.description) AS text,
                                    d.price,
                                    d.product_id,
                                    d.serial_no
                                FROM
                                    hrm_asset a
                                JOIN
                                    hrm_asset_brand AS b ON b.id = a.brand_id
                                JOIN
                                    hrm_asset_type AS c ON c.id = a.asset_type_id
                                JOIN
                                    hrm_asset_store_ledger AS d ON d.product_id = a.id
                                WHERE
                                    d.is_valid = 1
                                GROUP BY
                                    d.product_id, d.serial_no, d.hrm_asset_store_ledger_id, c.asset_type_name, b.brand_name, a.model, d.price
                                HAVING
                                    SUM(d.qty_stockin - d.qty_stockout) > 0");
                                    
        }
        return response()->json($data);
    }

    public function asset_data_old(Request $request){
        $data = [];
        if (!empty($request->term)){
            $data = DB::select("SELECT 
                                    f.id AS id,
                                    CONCAT(c.asset_type_name,
                                            ' | ',
                                            b.brand_name,
                                            ' | ',
                                            a.model,
                                            ' | ',
                                            d.serial_no) AS text,
                                    d.price,
                                    d.product_id,
                                    d.serial_no,
                                    d.id as asset_store_ledger_id
                                FROM
                                    hrm_asset a
                                JOIN
                                    hrm_asset_brand AS b ON b.id = a.brand_id
                                JOIN
                                    hrm_asset_type AS c ON c.id = a.asset_type_id
                                JOIN
                                    hrm_asset_store_ledger AS d ON d.product_id = a.id
                                JOIN
                                    hrm_asset_store_master AS e ON d.asset_store_master_id = e.id
                                JOIN
                                    hrm_asset_assign_master AS f ON f.hrm_asset_store_master_id = e.id
                                WHERE
                                    d.is_valid = 1 
                                GROUP BY 
                                    d.product_id , d.serial_no , asset_store_ledger_id, id ,c.asset_type_name,b.brand_name,a.model,d.price");
        
        }else{

            $data = DB::select("SELECT
                                    f.id AS id,
                                    CONCAT(c.asset_type_name,
                                            ' | ',
                                            b.brand_name,
                                            ' | ',
                                            a.model,
                                            ' | ',
                                            d.serial_no) AS text,
                                    d.price,
                                    d.product_id,
                                    d.serial_no,
                                    d.id as asset_store_ledger_id
                                FROM
                                    hrm_asset a
                                JOIN
                                    hrm_asset_brand AS b ON b.id = a.brand_id
                                JOIN
                                    hrm_asset_type AS c ON c.id = a.asset_type_id
                                JOIN
                                    hrm_asset_store_ledger AS d ON d.product_id = a.id
                                JOIN
                                    hrm_asset_store_master AS e ON d.asset_store_master_id = e.id
                                JOIN
                                    hrm_asset_assign_master AS f ON f.hrm_asset_store_master_id = e.id
                                WHERE
                                    d.is_valid = 1
                                GROUP BY
                                    d.product_id , d.serial_no , asset_store_ledger_id, id, c.asset_type_name,b.brand_name,a.model,d.price");
                                    
        }
        return response()->json($data);
    }

    public function asset_assign_list_select()
    {
        $asset_assign_list = [];
        $asset_assign_list = DB::select(
            "SELECT 
                a.id,
                CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model, ' | ', b.serial_no) as asset,
                CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', h.location_name) as employee,
                f.Images,
                i.depertment_name,
                j.designation_name,
                a.created_at
            FROM
                hrm_asset_assign_master as a
            JOIN
                hrm_asset_assign_ledger AS b ON a.id = b.asset_assign_master_id
            JOIN
                hrm_asset as c ON c.id = b.product_id
            JOIN
                hrm_asset_type as d ON d.id = c.asset_type_id
            JOIN
                hrm_asset_brand as e ON e.id = c.brand_id
            JOIN
                hrm_employee as f ON f.id = a.hrm_employee_id
            JOIN 
                hrm_employee_job_info g ON f.id=g.hrm_employee_id AND  f.active_status=1 AND g.employee_activity=1
            JOIN 
                hrm_location h On g.hrm_location_id=h.id 
            JOIN
                hrm_depertment i On g.hrm_depertment_id=i.id 
            JOIN 
                hrm_designation j On g.hrm_designation_id=j.id
            WHERE
                b.is_valid = 1 "
        );

        return response()->json($asset_assign_list);
    }


    public function assigned_list_employee(Request $request){
        $assigned_list_employee = [];
        $assigned_list_employee = DB::select
        ("SELECT 
            a.hrm_employee_id as id,
            CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', j.designation_name, ' | ', i.depertment_name, ' | ', h.location_name) as text
        FROM
            hrm_asset_assign_master as a  
        JOIN
            hrm_asset_assign_ledger AS b ON a.id = b.asset_assign_master_id AND a.is_valid = 1 AND b.is_valid = 1 AND a.status = 1
        JOIN
            hrm_employee as f ON f.id = a.hrm_employee_id
        JOIN 
            hrm_employee_job_info g ON f.id=g.hrm_employee_id AND  f.active_status=1 AND g.employee_activity=1
        JOIN 
            hrm_location h On g.hrm_location_id=h.id 
        JOIN
            hrm_depertment i On g.hrm_depertment_id=i.id 
        JOIN 
            hrm_designation j On g.hrm_designation_id=j.id
        WHERE
                f.employee_name LIKE '%$request->term%' 
            OR 
                g.employee_code LIKE '%$request->term%' 
            OR 
                j.designation_name LIKE '%$request->term%' 
            OR 
                i.depertment_name LIKE '%$request->term%'
            OR 
                h.location_name LIKE '%$request->term%' 
        GROUP BY id, text");

        return response()->json($assigned_list_employee);
    }

    public function asset_assign_list_get(Request $request)
    {
        if($request->employee_id == null){
            $asset_assign_list = DB::select
            ("SELECT 
                a.id,
                CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model, ' | ', b.serial_no, ' | ', c.description) as asset,
                CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', j.designation_name, ' | ', i.depertment_name, ' | ', h.location_name) as employee,
                f.Images,
                a.created_at,
                a.hrm_employee_id as employee_id,
                b.product_id as product_id
            FROM
                hrm_asset_assign_master as a
            JOIN
                hrm_asset_assign_ledger AS b ON a.id = b.asset_assign_master_id
            JOIN
                hrm_asset as c ON c.id = b.product_id
            JOIN
                hrm_asset_type as d ON d.id = c.asset_type_id
            JOIN
                hrm_asset_brand as e ON e.id = c.brand_id
            JOIN
                hrm_employee as f ON f.id = a.hrm_employee_id
            JOIN 
                hrm_employee_job_info g ON f.id=g.hrm_employee_id AND  f.active_status=1 AND g.employee_activity=1
            JOIN 
                hrm_location h On g.hrm_location_id=h.id 
            JOIN
                hrm_depertment i On g.hrm_depertment_id=i.id 
            JOIN 
                hrm_designation j On g.hrm_designation_id=j.id
            WHERE
                a.is_valid = 1 AND b.is_valid = 1 AND a.status = 1");
            return json_encode(array('data' => $asset_assign_list));

        }else{
            $asset_assign_list = DB::select
            ("SELECT 
                a.id,
                CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model, ' | ', b.serial_no, ' | ', c.description) as asset,
                CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', j.designation_name, ' | ', i.depertment_name, ' | ', h.location_name) as employee,
                f.Images,
                CAST(a.created_at AS date) as MYDATE,
                a.hrm_employee_id as employee_id,
                b.product_id as product_id
            FROM
                hrm_asset_assign_master as a
            JOIN
                hrm_asset_assign_ledger AS b ON a.id = b.asset_assign_master_id AND a.hrm_employee_id = $request->employee_id AND a.is_valid = 1 AND b.is_valid = 1 AND a.status = 1
            JOIN
                hrm_asset as c ON c.id = b.product_id
            JOIN
                hrm_asset_type as d ON d.id = c.asset_type_id
            JOIN
                hrm_asset_brand as e ON e.id = c.brand_id
            JOIN
                hrm_employee as f ON f.id = a.hrm_employee_id
            JOIN 
                hrm_employee_job_info g ON f.id=g.hrm_employee_id AND  f.active_status=1 AND g.employee_activity=1
            JOIN 
                hrm_location h On g.hrm_location_id=h.id 
            JOIN
                hrm_depertment i On g.hrm_depertment_id=i.id 
            JOIN 
                hrm_designation j On g.hrm_designation_id=j.id
            ");
        // dd($asset_assign_list);

            return json_encode(array('data' => $asset_assign_list));

        }
    }
}
