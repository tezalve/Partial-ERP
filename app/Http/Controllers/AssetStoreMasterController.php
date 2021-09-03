<?php

namespace App\Http\Controllers;

use App\models\{ HrmAssetStoreMaster, HrmAssetStoreLedger, HrmAssetPurchaseMaster, HrmAssetPurchaseLedger };
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

class AssetStoreMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('assetstore.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assetstore.create');
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
            "po_date" => 'required',
            "notes" => 'required',
            "serial" => 'required',
            "qty_info" => 'required',
            "price_info" => 'required',
            "product_id" => 'required'
        ]);

        if( $validator->fails() ){
            // return Response::json(array(
            //     'success'   => false,
            //     'messages'  => implode(",",$validator->getMessageBag()->all()),
            //     'errors'    => $validator->getMessageBag()->toArray()
            // ));
        }
        
        $store = new DataController();
        $store_no = $store->generate_registration('hrm_asset_purchase_master', 'purchase_no');
       
        DB::beginTransaction();
        try {

            $asset_master = new HrmAssetStoreMaster;
            $asset_master->transaction_type = 1;
            $asset_master->store_no = $store_no;
            $asset_master->users_id = auth()->user()->id;

            $asset_master->save();

            $asset_purchase_master = new HrmAssetPurchaseMaster;
            $asset_purchase_master->asset_store_master_id = $asset_master->id;
            $asset_purchase_master->purchase_date = $request->po_date;
            $asset_purchase_master->note = $request->notes;
            $asset_purchase_master->purchase_no = $store_no;
            $asset_purchase_master->users_id = auth()->user()->id;
            $asset_purchase_master->save();

            for($i=0; $i<count($request->product_id); $i++){

                $asset_ledger = new HrmAssetStoreLedger;
                $asset_ledger->asset_store_master_id = $asset_master->id;
                $asset_ledger->product_id = $request->product_id[$i];
                $asset_ledger->price = $request->price_info[$i];
                $asset_ledger->serial_no = $request->serial[$i];
                $asset_ledger->qty_stockin = $request->qty_info[$i];
                $asset_ledger->save();
                
                DB::UPDATE("UPDATE hrm_asset_store_ledger SET hrm_asset_store_ledger_id= $asset_ledger->id WHERE  id= $asset_ledger->id");
                

                $asset_purchase_ledger = new HrmAssetPurchaseLedger;
                $asset_purchase_ledger->asset_purchase_master_id = $asset_purchase_master->id;
                $asset_purchase_ledger->product_id = $request->product_id[$i];
                $asset_purchase_ledger->price = $request->price_info[$i];
                $asset_purchase_ledger->serial_no = $request->serial[$i];
                $asset_purchase_ledger->qty_stockin = $request->qty_info[$i];
                $asset_purchase_ledger->save();    
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return Redirect()->back()->with('error', 'Request could not be processed!');
        }
        
        return redirect()->route('assetstore.index')->with('success', 'Data has been successfully inserted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\HrmAssetStoreMaster  $hrmAssetStoreMaster
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAssetStoreMaster $hrmAssetStoreMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\HrmAssetStoreMaster  $hrmAssetStoreMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hrmAssetStoreLedger = HrmAssetStoreLedger::select('hrm_asset_store_ledger.id as id', 'hrm_asset_store_ledger.asset_store_master_id as asset_store_master_id', 'hrm_asset_store_ledger.serial_no as serial_no', 'hrm_asset_store_ledger.price as price', 'hrm_asset_store_ledger.product_id as product_id', 'hrm_asset_store_ledger.qty_stockin as qty_stockin', 'a.model as model', 'b.asset_type_name as asset_type_name', 'c.brand_name as brand_name')
        ->join('hrm_asset as a', 'hrm_asset_store_ledger.product_id', '=', 'a.id')
        ->join('hrm_asset_type as b', 'a.asset_type_id', '=', 'b.id')
        ->join('hrm_asset_brand as c', 'a.brand_id', '=', 'c.id')
        ->join('hrm_asset_purchase_master as d', 'd.asset_store_master_id', '=', 'hrm_asset_store_ledger.asset_store_master_id')
        ->where('hrm_asset_store_ledger.asset_store_master_id', '=', $id)->get();
        
        $hrmAssetPurchaseMaster = HrmAssetPurchaseMaster::where('asset_store_master_id', '=', $id)->first();
        // dd($hrmAssetStoreLedger, $hrmAssetPurchaseMaster);
        return view('assetstore.edit', compact('hrmAssetPurchaseMaster', 'hrmAssetStoreLedger'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\HrmAssetStoreMaster  $hrmAssetStoreMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $activity = DB::table('hrm_asset_store_master')->where('is_valid','=',0)
        ->where('id','=',$id)->first();  
    
        if (!empty($activity)){
                return response::json(array(
                    'success'   => false,
                    'messages'  => 'This data already updated, Please check!',
                ));
        }
        
        $find_data = DB::table('hrm_asset_store_master')->where('id','=',$id)->first();
        $find_po = DB::table('hrm_asset_purchase_master')->where('asset_store_master_id','=',$id)->first();
    
        // dd($request->all());
        // dd($id);
        $validator = Validator::make($request->all(), [
            "po_date" => 'required',
            "notes" => 'required',
            "serial" => 'required',
            "qty_info" => 'required',
            "price_info" => 'required',
            "product_id" => 'required'
        ]);

        if( $validator->fails() ){
            // return Response::json(array(
            //     'success'   => false,
            //     'messages'  => implode(",",$validator->getMessageBag()->all()),
            //     'errors'    => $validator->getMessageBag()->toArray()
            // ));
        }
        
        $store_no = $find_data->store_no;

        DB::beginTransaction();
        try {

            HrmAssetStoreMaster::where('id',$id)->update(['is_valid' => 0]);
            HrmAssetStoreLedger::where('asset_store_master_id',$id)->update(['is_valid' => 0]);
            HrmAssetPurchaseMaster::where('asset_store_master_id',$id)->update(['is_valid' => 0]);
            HrmAssetPurchaseLedger::where('asset_purchase_master_id',$find_po->id)->update(['is_valid' => 0]);
            


            $asset_master = new HrmAssetStoreMaster;
            $asset_master->transaction_type = 1;
            $asset_master->store_no = $store_no;
            $asset_master->users_id = auth()->user()->id;

            $asset_master->save();

            $asset_purchase_master = new HrmAssetPurchaseMaster;
            $asset_purchase_master->asset_store_master_id = $asset_master->id;
            $asset_purchase_master->purchase_date = $request->po_date;
            $asset_purchase_master->note = $request->notes;
            $asset_purchase_master->purchase_no = $store_no;
            $asset_purchase_master->users_id = auth()->user()->id;
            $asset_purchase_master->save();

            for($i=0; $i<count($request->product_id); $i++){

                $asset_ledger = new HrmAssetStoreLedger;
                $asset_ledger->asset_store_master_id = $asset_master->id;
                $asset_ledger->product_id = $request->product_id[$i];
                $asset_ledger->price = $request->price_info[$i];
                $asset_ledger->serial_no = $request->serial[$i];
                $asset_ledger->qty_stockin = $request->qty_info[$i];
                $asset_ledger->save();
                
                DB::UPDATE("UPDATE hrm_asset_store_ledger SET hrm_asset_store_ledger_id= $asset_ledger->id WHERE  id= $asset_ledger->id");
                

                $asset_purchase_ledger = new HrmAssetPurchaseLedger;
                $asset_purchase_ledger->asset_purchase_master_id = $asset_purchase_master->id;
                $asset_purchase_ledger->product_id = $request->product_id[$i];
                $asset_purchase_ledger->price = $request->price_info[$i];
                $asset_purchase_ledger->serial_no = $request->serial[$i];
                $asset_purchase_ledger->qty_stockin = $request->qty_info[$i];
                $asset_purchase_ledger->save();    
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return Redirect()->back()->with('error', 'Request could not be processed!');
        }
        
        return redirect()->route('assetstore.index')->with('success', 'Data has been successfully inserted');


        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     "po_date" => 'required',
        //     "notes" => 'required',
        // ]);

        // // if ($request->product_id != null){
        // //     DB::beginTransaction();
        // //     try {
        //         $asset_purchase_master = HrmAssetPurchaseMaster::where('asset_store_master_id', '=', $id)->first();
        //         $asset_purchase_master->purchase_date = $request->po_date;
        //         $asset_purchase_master->note = $request->notes;
        //         $asset_purchase_master->save();

        //         $count = HrmAssetStoreLedger::where('asset_store_master_id', '=', $id)->get();
        //         $j=0;
        //         for($i=0; $i<count($request->product_id); $i++){
        //             if($request->ledger_id[$i] == 'new'){
        //                 $asset_ledger = new HrmAssetStoreLedger;
        //                 $asset_ledger->asset_store_master_id = $asset_master->id;

        //                 $asset_purchase_ledger = new HrmAssetPurchaseLedger;
        //                 $asset_purchase_ledger->asset_purchase_master_id = $asset_master->id;
        //             } else {
        //                 $asset_ledger = HrmAssetStoreLedger::find($request->ledger_id[$i]);

        //                 $asset_purchase_ledger = HrmAssetPurchaseLedger::find($request->ledger_id[$i]);
        //                 $j++;
        //             }

        //             $asset_ledger->product_id = $request->product_id[$i];
        //             $asset_ledger->price = $request->price_info[$i];
        //             $asset_ledger->serial_no = $request->serial_no[$i];
        //             $asset_ledger->qty_stockin = $request->qty_info[$i];

        //             $asset_purchase_ledger->product_id = $request->product_id[$i];
        //             $asset_purchase_ledger->price = $request->price_info[$i];
        //             $asset_purchase_ledger->serial_no = $request->serial_no[$i];
        //             $asset_purchase_ledger->qty_stockin = $request->qty_info[$i];

        //             $asset_ledger->save();
        //             $asset_purchase_ledger->save();
        //         }
            
        //         // dd($count->id);
        //         if (count($count) > $j){
        //             // dd($ids, $request->ledger_id);
        //             for($i=0; $i<count($count); $i++){
        //                 if (in_array(($count[$i]->id), $request->ledger_id) == false) {

        //                     $asset_ledger_delete = HrmAssetStoreLedger::find($count[$i]->id);
        //                     $asset_purchase_ledger_delete = HrmAssetPurchaseLedger::find($count[$i]->id);

        //                     $asset_ledger_delete->delete();
        //                     $asset_purchase_ledger_delete->delete();
        //                 }
        //             }
        //         }

        // //         DB::commit();

        // //     } catch (\Exception $e) {
        // //         DB::rollback();
        // //         return Redirect()->back()->with('error', 'Request could not be processed');
        // //     }
        // //     return redirect()->route('assetstore.index')->with('success', 'data inserted!');

        // // }else {
        // //     echo '<script>alert("Datatable empty!")</script>';
        // //     return redirect()->back()->with('error', 'Unsuccessfull!');
        // // }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\HrmAssetStoreMaster  $hrmAssetStoreMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(HrmAssetStoreMaster $hrmAssetStoreMaster)
    {
        //
    }

    public function asset_store_list()
    {
        $asset_list = DB::select
        ("SELECT 
        a.id,
        aa.purchase_date,
        aa.note,
        aa.purchase_no,
        SUM(b.qty_stockin) AS qty,
        SUM(b.qty_stockin * b.price) AS total,
        GROUP_CONCAT(CONCAT(d.asset_type_name, ' | ', e.brand_name, ' | ', c.model)
            SEPARATOR '<br>') AS item_description,
        GROUP_CONCAT(CONCAT(b.serial_no)
            SEPARATOR '<br>') AS serial,
        GROUP_CONCAT(CONCAT(b.price)
            SEPARATOR '<br>') AS price,
        GROUP_CONCAT(CONCAT(b.qty_stockin)
            SEPARATOR '<br>') AS qty2,
        GROUP_CONCAT(CONCAT(ROUND(b.price * b.qty_stockin))
            SEPARATOR '<br>') AS total2
    FROM
        hrm_asset_store_master AS a
            JOIN
        hrm_asset_purchase_master as aa ON a.id=aa.asset_store_master_id and a.is_valid=1 and aa.is_valid=1 
            JOIN
        hrm_asset_store_ledger AS b ON a.id = b.asset_store_master_id and b.is_valid=1
            JOIN
        hrm_asset AS c ON c.id = b.product_id
            JOIN
        hrm_asset_type AS d ON d.id = c.asset_type_id
            JOIN
        hrm_asset_brand AS e ON e.id = c.brand_id
    WHERE
        b.qty_stockin != 0
    GROUP BY  a.id,
        aa.purchase_date,
        aa.note,
        aa.purchase_no");
        // dd($asset_list);
        return json_encode(array('data' => $asset_list));
    }

        // GROUP_CONCAT(CONCAT(b.product_id)
        //     SEPARATOR '<br>') AS item_description,
        // GROUP_CONCAT(CONCAT(b.serial_no)
        //     SEPARATOR '<br>') AS serial,
        // GROUP_CONCAT(CONCAT(b.price)
        //     SEPARATOR '<br>') AS price,
        // GROUP_CONCAT(CONCAT(b.qty_stockin)
        //     SEPARATOR '<br>') AS qty,
        // GROUP_CONCAT(CONCAT(ROUND(b.price * b.qty_stockin))
        //     SEPARATOR '<br>') AS total
}
