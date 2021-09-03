<?php

namespace App\Http\Controllers;

use App\models\{ HrmAssetType, HrmAssetInformation };
use Illuminate\Http\Request;
use Validator;
use DB;
use Response;

class AssetTypeController extends Controller
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
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
            'asset_type_name'    => 'required|string|max:255|unique:hrm_asset_type,asset_type_name',
        ]);

        if( $validator->fails() ){
            return response::json(array(
                'success'   => false,
                'message'  => 'Failure, validation fail!'
            ));
        } 

        DB::beginTransaction();
        try {
        $asset_type = HrmAssetType::find($request->asset_type_id);
        
        if ($asset_type==null){
            $asset_type = new HrmAssetType;
        }

        $asset_type->asset_type_name = $request->asset_type_name;
        $asset_type->users_id = auth()->user()->id;

        $asset_type->save();
        DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return response::json(array(
                'success'   => false,
                'message'   => 'Failure',
            ));
        }
        // Session::flash('message','Successfully Insert!');
        // Session::flash('alert-type','success');
        // return redirect()->back();
        return response::json(array(
            'success'   => true,
            'message'   => 'Success',
        ));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\HrmAssetType  $hrmAssetType
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAssetType $hrmAssetType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\HrmAssetType  $hrmAssetType
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmAssetType $hrmAssetType)
    {
        return view('assettype.edit', compact('hrmAssetType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\HrmAssetType  $hrmAssetType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrmAssetType $hrmAssetType)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\HrmAssetType  $hrmAssetType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hrmAssetType = HrmAssetType::where('id', $id)->first();
        $HrmAssetInformation = HrmAssetInformation::where('asset_type_id', $id)->first();
        // dd($HrmAssetInformation, $id);
        if ($HrmAssetInformation==null){
            // dd($HrmAssetBrand);
            $hrmAssetType->delete();
            session()->flash('success', 'data has been successfully deleted!');
            return redirect()->route('asset.index');
        }else{
            session()->flash('warning', 'Data has a dependency!');
            return redirect()->route('asset.index');
        }
    }

    public function asset_type_list()
    {
        $asset_type_list = DB::select("SELECT * FROM hrm_asset_type");
        return json_encode(array('data' => $asset_type_list));
    }

    public function asset_type_list_data(Request $request){
        $data = [];
        if (!empty($request->term)){
        $data = DB::select("SELECT id,asset_type_name as text FROM hrm_asset_type
                                WHERE asset_type_name LIKE '%$request->term%' ;");
        
        }else{
            $data = DB::select("SELECT id,asset_type_name as text FROM hrm_asset_type
                                    WHERE asset_type_name LIKE '%$request->term%' ;");
        }
            return response()->json($data);
    }
}
