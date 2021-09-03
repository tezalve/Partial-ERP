<?php

namespace App\Http\Controllers;

use App\models\{ HrmAssetReturnMaster, HrmAssetStoreMaster, HrmAssetStoreLedger, HrmAssetAssignMaster, HrmAssetAssignLedger};
use Illuminate\Http\Request;
use DB;
use Validator;
use Response;

class AssetReturnMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('assetreturn.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assetreturn.create');
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
        $find_data = HrmAssetAssignMaster::join('hrm_asset_store_master as a', 'a.id', '=', 'hrm_asset_assign_master.hrm_asset_store_master_id')
        ->join('hrm_asset_store_ledger as b', 'b.asset_store_master_id', '=', 'a.id')
        ->where('hrm_asset_assign_master.id','=',$request->hrm_asset_assign_master_id)->first();

        // dd($find_data);

        DB::beginTransaction();
        try {
            $asset_master = new HrmAssetStoreMaster;
            $asset_master->transaction_type = 3;
            $asset_master->store_no='sdsd';
            $asset_master->users_id = auth()->user()->id;
            $asset_master->save();

            $asset_return = new HrmAssetReturnMaster;
            $asset_return->hrm_asset_assign_master_id = $request->hrm_asset_assign_master_id;
            $asset_return->hrm_asset_store_master_id = $asset_master->id;
            $asset_return->hrm_asset_return_type_id = $request->asset_return_type_id;
            $asset_return->note = $request->note;
            $asset_return->save();

            if($request->asset_return_type_id == 1){
                
                $asset_ledger = new HrmAssetStoreLedger;
                $asset_ledger->asset_store_master_id = $asset_master->id;
                $asset_ledger->product_id = $find_data->product_id;
                $asset_ledger->price =  $find_data->price;
                $asset_ledger->serial_no = $find_data->serial_no;
                $asset_ledger->qty_stockin = 1;
                $asset_ledger->qty_stockout = 0;
                $asset_ledger->hrm_asset_store_ledger_id=$find_data->hrm_asset_store_ledger_id;
                $asset_ledger->save();

                $asset_assign = HrmAssetAssignMaster::find($request->hrm_asset_assign_master_id);
                $asset_assign->status = 2;
                $asset_assign->save();

            }
            if($request->asset_return_type_id == 2){

                $asset_ledger = new HrmAssetStoreLedger;
                $asset_ledger->asset_store_master_id = $asset_master->id;
                $asset_ledger->product_id = $find_data->product_id;
                $asset_ledger->price =  $find_data->price;
                $asset_ledger->serial_no = $find_data->serial_no;
                $asset_ledger->qty_stockin = 1;
                $asset_ledger->qty_stockout = 1;
                $asset_ledger->hrm_asset_store_ledger_id=$find_data->hrm_asset_store_ledger_id;
                $asset_ledger->save();

                $asset_assign = HrmAssetAssignMaster::find($request->hrm_asset_assign_master_id);
                $asset_assign->status = 3;
                $asset_assign->save();
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return Redirect()->back()->with('error', 'Request could not be processed');
        }

        return Redirect()->back()->with('success', 'Retuned successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\HrmAssetReturnMaster  $HrmAssetReturnMaster
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAssetReturnMaster $HrmAssetReturnMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\HrmAssetReturnMaster  $HrmAssetReturnMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmAssetReturnMaster $HrmAssetReturnMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\HrmAssetReturnMaster  $HrmAssetReturnMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrmAssetReturnMaster $HrmAssetReturnMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\HrmAssetReturnMaster  $HrmAssetReturnMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($HrmAssetReturnMaster)
    {
        $asset_return = HrmAssetReturnMaster::select('hrm_asset_return_master.id as id', 'a.id as hrm_asset_store_master_id', 'b.id as hrm_asset_store_ledger_id', 'hrm_asset_return_master.hrm_asset_assign_master_id as hrm_asset_assign_master_id')
        ->join('hrm_asset_store_master as a', 'a.id', '=', 'hrm_asset_return_master.hrm_asset_store_master_id')
        ->join('hrm_asset_store_ledger as b', 'b.asset_store_master_id', '=', 'a.id')
        ->where('hrm_asset_return_master.id', '=', $HrmAssetReturnMaster)
        ->first();

        DB::beginTransaction();
        try {
            HrmAssetReturnMaster::find($HrmAssetReturnMaster)->update(['is_valid' => 0]);
            HrmAssetStoreLedger::find($asset_return->hrm_asset_assign_master_id)->update(['is_valid' => 0]);
            HrmAssetStoreMaster::find($asset_return->hrm_asset_store_master_id)->update(['is_valid' => 0]);

            $asset_assign = HrmAssetAssignMaster::find($asset_return->hrm_asset_assign_master_id);
            $asset_assign->status = 1;
            $asset_assign->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return Redirect()->back()->with('error', 'Request could not be processed');
        }

        return Redirect()->back()->with('success', 'Deleted successfully!');
    }

    public function asset_return_list()
    {
        $asset_assign_list = DB::select
        ("SELECT
            k.id as id,
            CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model, ' | ', b.serial_no, ' | ', c.description) as asset,
            CONCAT(f.employee_name, ' | ', g.employee_code, ' | ', j.designation_name, ' | ', i.depertment_name, ' | ', h.location_name) as employee,
            f.Images as imgpath,
            k.created_at as created_at,
            l.asset_return_type_name as return_type
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
            hrm_location h ON g.hrm_location_id=h.id 
        JOIN
            hrm_depertment i ON g.hrm_depertment_id=i.id 
        JOIN 
            hrm_designation j ON g.hrm_designation_id=j.id
        JOIN
            hrm_asset_return_master as k ON a.id = k.hrm_asset_assign_master_id
        JOIN
            hrm_asset_return_type as l ON l.id = k.hrm_asset_return_type_id
        WHERE
            a.is_valid = 1 AND b.is_valid = 1 AND a.status != 1");

        return json_encode(array('data' => $asset_assign_list));
    }
}
