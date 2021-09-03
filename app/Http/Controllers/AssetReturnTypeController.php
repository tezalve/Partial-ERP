<?php

namespace App\Http\Controllers;

use App\models\HrmAssetReturnType;
use Illuminate\Http\Request;
use Validator;
use DB;
use Response;

class AssetReturnTypeController extends Controller
{
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
        // dd($request);
        $validator = Validator::make($request->all(), [
            'asset_return_type_name' => 'required|string|max:255|unique:hrm_asset_return_type,asset_return_type_name'
        ]);

        if( $validator->fails() ){
            return response::json(array(
                'success'   => false,
                'message'  => 'Failure, validation fail!'
            ));
        } 

        DB::beginTransaction();
        try {
            $asset_return_type = HrmAssetReturnType::find($request->asset_return_type_id);
            if ($asset_return_type==null){
                $asset_return_type = new HrmAssetReturnType;
            }

            $asset_return_type->asset_return_type_name = $request->asset_return_type_name;
            $asset_return_type->users_id = auth()->user()->id;

            $asset_return_type->save();
            // dd($asset_return_type);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response::json(array(
                'success'   => false,
                'message'   => 'failure!'
            ));
        }
        return response::json(array(
            'success'   => true,
            'message'   => 'Success!'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\HrmAssetReturnType  $HrmAssetReturnType
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAssetReturnType $HrmAssetReturnType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\HrmAssetReturnType  $HrmAssetReturnType
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmAssetReturnType $HrmAssetReturnType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\HrmAssetReturnType  $HrmAssetReturnType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrmAssetReturnType $HrmAssetReturnType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\HrmAssetReturnType  $HrmAssetReturnType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $HrmAssetReturnType = HrmAssetReturnType::where('id', $id)->first();
        $HrmAssetReturnType->delete();

        return redirect()->route('asset.index')->with('success', 'destroyed! with lightning speed');
    }

    public function return_type_list()
    {
        $return_type_list = DB::select("SELECT * FROM hrm_asset_return_type");
        return json_encode(array('data' => $return_type_list));
    }

    public function return_type_list_data(Request $request){
        $data = [];
        if (!empty($request->term)){
        $data = DB::select("SELECT id,asset_return_type_name as text FROM hrm_asset_return_type
                                WHERE asset_return_type_name LIKE '%$request->term%' ;");
        
        }else{
            $data = DB::select("SELECT id,asset_return_type_name as text FROM hrm_asset_return_type
                                    WHERE asset_return_type_name LIKE '%$request->term%' ;");
        }
            return response()->json($data);
    }
}
