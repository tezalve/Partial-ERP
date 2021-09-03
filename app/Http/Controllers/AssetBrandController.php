<?php

namespace App\Http\Controllers;

use App\models\{ HrmAssetBrand, HrmAssetInformation };
use Illuminate\Http\Request;
use Validator;
use DB;
use Response;

class AssetBrandController extends Controller
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
            'brand_name' => 'required|string|max:255|unique:hrm_brand,brand_name'
        ]);

        if( $validator->fails() ){
            return response::json(array(
                'success'   => false,
                'message'  => 'Failure, validation fail!'
            ));
        } 

        DB::beginTransaction();
        try {
            $brand = HrmAssetBrand::find($request->brand_id);
            // dd($brand);
            if ($brand==null){
                $brand = new HrmAssetBrand;
            }

            $brand->brand_name = $request->brand_name;
            $brand->users_id = auth()->user()->id;

            $brand->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return Redirect()->back()->with('error', 'Request could not be processed');
        }
        // Session::flash('message','Successfully Insert!');
        // Session::flash('alert-type','success');

        return response::json(array(
            'success'   => true,
            'message'   => 'Success!'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\HrmAssetBrand  $HrmAssetBrand
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAssetBrand $HrmAssetBrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\HrmAssetBrand  $HrmAssetBrand
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmAssetBrand $HrmAssetBrand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\HrmAssetBrand  $HrmAssetBrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrmAssetBrand $HrmAssetBrand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\HrmAssetBrand  $HrmAssetBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $HrmAssetBrand = HrmAssetBrand::where('id', $id)->first();
        $HrmAssetInformation = HrmAssetInformation::where('brand_id', $id)->first();
        // dd($HrmAssetInformation, $HrmAssetBrand);
        if ($HrmAssetInformation==null){
            // dd($HrmAssetBrand);
            $HrmAssetBrand->delete();
            session()->flash('success', 'data has been successfully deleted!');
            return redirect()->route('asset.index');
        }else{
            session()->flash('warning', 'data has a dependency');
            return redirect()->route('asset.index');
        }
        
    }

    public function brand_list()
    {
        $brand_list = DB::select("SELECT * FROM hrm_asset_brand");
        return json_encode(array('data' => $brand_list));
    }

    public function brand_list_data(Request $request){
        $data = [];
        if (!empty($request->term)){
        $data = DB::select("SELECT id,brand_name as text FROM hrm_asset_brand
                                WHERE brand_name LIKE '%$request->term%' ;");
        
        }else{
            $data = DB::select("SELECT id,brand_name as text FROM hrm_asset_brand
                                    WHERE brand_name LIKE '%$request->term%' ;");
        }
            return response()->json($data);
    }
}
