<?php

namespace App\Http\Controllers;

use App\models\{ HrmAssetInformation, HrmAssetStoreLedger };
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

class AssetInformationController extends Controller
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
        return view('assetinformation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assetinformation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(public_path());
        $validator = Validator::make($request->all(), [
            'description'    => 'required',
            'model'    => 'required',
            'asset_type_id'    => 'required',
            'brand_id'    => 'required',
            'imgpath'    => 'required',
        ]);

        if( $validator->fails() ){
            return response::json(array(
                'success'   => false,
                'message'  => 'Failure, validation fail!'
            ));
        } 

        DB::beginTransaction();
        try {
            
            if(!empty($request->imgpath)) {     
                $valid_exts = array('jpeg', 'jpg', 'png', 'gif');     // valid extensions
                $max_size = 2000 * 1024;                              // max file size (200kb)
                $path = public_path() . '/asset_images/'; // upload directory
                // if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
                    $file = $request->imgpath;
                    $ext  = $file->guessClientExtension();
                    $size = $file->getClientSize();
                    // $name = $file->getClientOriginalName();
                    $name = $this->generateRandomString();
                    if (in_array($ext, $valid_exts) AND $size < $max_size){
                        if ($file->move($path, $name)){
                            $status = 'Image successfully uploaded!';
                            $fileName = $name;
                        }
                    }
            }

            $asset = new HrmAssetInformation;
            $asset->description = $request->description;
            $asset->model = $request->model;
            $asset->asset_type_id = $request->asset_type_id;
            $asset->brand_id = $request->brand_id;
            $asset->imgpath = $fileName;
            $asset->users_id = auth()->user()->id;
            $asset->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return Redirect()->back()->with('error', 'Could not process request!');
        }

        return response::json(array(
            'success'   => true,
            'message'   => 'Success!'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\HrmAssetInformation  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(HrmAssetInformation $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\HrmAssetInformation  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(HrmAssetInformation $asset)
    {
        

        $assetid = $asset->asset_type_id;
        $brandid = $asset->brand_id;

        // dd($assetid, $assett);

        return view('assetinformation.edit', compact('asset', 'assetid', 'brandid'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\HrmAssetInformation  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HrmAssetInformation $asset)
    {
        $validator = Validator::make($request->all(), [
            'description'    => 'required',
            'model'    => 'required',
        ]);
        
        // if( $validator->fails() ){
        //     return Response::json(array(
        //         'success'   => false,
        //         'messages'  => implode(",",$validator->getMessageBag()->all()),
        //         'errors'    => $validator->getMessageBag()->toArray()
        //     ));
        // }
        
        // dd($request->all());

        DB::beginTransaction();
        try {
            
            if(!empty($request->imgpath)) {     
                $valid_exts = array('jpeg', 'jpg', 'png', 'gif');     // valid extensions
                $max_size = 2000 * 1024;                              // max file size (200kb)
                $path = public_path() . '/asset_images/'; // upload directory
                // if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
                    $file = $request->imgpath;
                    $ext  = $file->guessClientExtension();
                    $size = $file->getClientSize();
                    // $name = $file->getClientOriginalName();
                    $name = $this->generateRandomString();
                    if (in_array($ext, $valid_exts) AND $size < $max_size){
                        if ($file->move($path, $name)){
                            $status = 'Image successfully uploaded!';
                            $fileName = $name;
                        }
                    }
                    
            }
            $asset = HrmAssetInformation::find($asset->id);
            $asset->description = $request->description;
            $asset->model = $request->model;
            $asset->asset_type_id = $request->asset_type_id;
            $asset->brand_id = $request->brand_id;
            if(!empty($request->imgpath)) {
                $asset->imgpath = $fileName;
            }
            $asset->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return Redirect()->back()->with('error', 'Could not process request!');
        }
        
        return response::json(array(
            'success'   => true,
            'message'   => 'Success!'
         ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\HrmAssetInformation  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy($asset)
    {
        $asset_store = HrmAssetStoreLedger::where('product_id', '=', $asset)->first();
        $asset = HrmAssetInformation::where('id', $asset)->first();
        // dd($hrmBrand);
        if($asset_store == null){
            $asset->delete();
            session()->flash('success', 'data has been successfully deleted!');
            return redirect()->route('asset.index');
        }else{
            session()->flash('warning', 'Product Exists On Ledger!');
            return redirect()->route('asset.index');
        }
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

    public function asset_list()
    {
        $asset_list = DB::select("SELECT a.id, a.description, a.model, a.imgpath, b.brand_name as brand, c.asset_type_name as asset_type FROM hrm_asset as a
        LEFT JOIN hrm_asset_brand as b on b.id = a.brand_id
        LEFT JOIN hrm_asset_type as c on c.id = a.asset_type_id");
        return json_encode(array('data' => $asset_list));
    }

    public function asset_list_data(Request $request){
        $data = [];
        if (!empty($request->term)){
            $data = DB::select("SELECT a.id, CONCAT(c.asset_type_name, ' | ', b.brand_name, ' | ', a.model, ' | ', a.description) as text 
                            FROM hrm_asset a 
                            JOIN hrm_asset_brand as b on b.id = a.brand_id
                            JOIN hrm_asset_type as c on c.id = a.asset_type_id");
        
        }else{
            $data = DB::select("SELECT a.id, CONCAT(c.asset_type_name, ' | ', b.brand_name, ' | ', a.model, ' | ', a.description) as text
                                FROM hrm_asset a 
                                JOIN hrm_asset_brand as b on b.id = a.brand_id
                                JOIN hrm_asset_type as c on c.id = a.asset_type_id
                                WHERE c.asset_type_name LIKE '%$request->term%'  
                                OR b.brand_name LIKE '%$request->term%' 
                                OR a.model LIKE '%$request->term%';");
        }
            return response()->json($data);
    }
}
