<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use App\Models\Vendor\VendorBankDetails;
use App\Models\Vendor\VendorDocuments;
use App\Models\Vendor\VendorBusinessTypes;
use App\Models\Vendor\VendorProductType;
use App\Models\Vendor\VendorBusinessNature;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// use App\Http\Middleware\OwnerAuth;


class OwnerController extends Controller
{
    // Vendor System

    function vendor_list()
    {
        $data = Vendor::getVendorList();
        return view('owner.vendor_related.vendor_list')->with("data",$data);

        //$vendors = Vendor::with('get_stores')->get();
        // $vendors = Vendor::getVendorList();
        //return view('owner.vendor_related.vendor_list', compact('vendors'));
    }

    function vendor_create()
    {
        $data3=VendorBusinessTypes::where("status",1)->get();
        $data4=VendorBusinessNature::where("status",1)->get();
        $data5=VendorProductType::where("status",1)->get();
        return view('owner.vendor_related.vendor_create')->with("data3",$data3)->with("data4",$data4)->with("data5",$data5);
    }
    function vendorinfo_update($id)
    {
        $v_id=$id;
        $data=Vendor::where("id",$v_id)->get();
        $data1=VendorBankDetails::where("vendor_id",$v_id)->get();
        $data2=VendorDocuments::where("vendor_id",$v_id)->get();

        $data3=VendorBusinessTypes::where("status",1)->get();
        $data4=VendorBusinessNature::where("status",1)->get();
        $data5=VendorProductType::where("status",1)->get();
        return view('owner.vendor_related.vendorinfo_update')->with("data",$data)->with("data1",$data1)->with("data2",$data2)->with("data3",$data3)->with("data4",$data4)->with("data5",$data5);

    }
    function status_update(Request $request){

        $status=1;
        $info = Vendor::findOrFail($request->id);
        $currentstatus = $info->status;

        if($currentstatus==1)
        {
            $status=2;
        }

        $info->update([
            'status' => $status,
        ]);
        return back()->with('success');


    }
    function vendor_update_submit(Request $request){

        if(!empty($request->password))
        {
            $validatedData = $request->validate([
                'password' => 'required_with:confirm_password|same:confirm_password|min:3',
            ]);
        }
        else{

            $vendor_id= $request->id;

            $vendor_info = Vendor::findOrFail($vendor_id);
            $old_imgname = $vendor_info->image;
            //$v_img=$old_imgname;
            if($request->user_image)
            {
                if ($request->hasFile('user_image'))
                {
                    // if (File::exists(public_path("/images/vendor/vendor_img/".$old_imgname))) {
                    //     File::delete(public_path("/images/vendor/vendor_img/".$old_imgname));
                    // }
                    // else{
                    //     return "something wrong";
                    // }
                    if(!empty($old_imgname)){
                        //$res["imgLocation"]= Storage::disk('s3')->url(helperAwsLocation());
                        $destinationFolder=helperAwsLocation(3)."".$old_imgname;
                        Storage::disk('s3')->delete($destinationFolder);
                    }    

                    $image = $request->user_image;
                    $v_img = time().uniqid().$image->getClientOriginalExtension();
                    //$destinationPath = public_path('/images/vendor/vendor_img');
                    //$image->move($destinationPath, $v_img);

                    $destinationFolder=helperAwsLocation(3)."".$v_img;
                    Storage::disk('s3')->put($destinationFolder,
                    fopen($request->file('user_image'), 'r+'), 's3');
                }
            }
            else{
                $v_img = $old_imgname;
            }

            $old_imgname = $vendor_info->nid_front_img;
            if($request->nid_img_front)
            {
                if ($request->hasFile('nid_img_front'))
                {
                    if (File::exists(public_path("/images/vendor/nid_img/".$old_imgname))) {
                        File::delete(public_path("/images/vendor/nid_img/".$old_imgname));
                    }
                    else{
                        return "something wrong";
                    }
                    $image = $request->nid_img_front;
                    $nidf_img = time().uniqid().$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/vendor/nid_img');
                    $image->move($destinationPath, $nidf_img);
                }
            }
            else{
                $nidf_img = $old_imgname;
            }

            $old_imgname = $vendor_info->nid_back_img;
            if($request->nid_img_back)
            {
                if ($request->hasFile('nid_img_back'))
                {
                    if (File::exists(public_path("/images/vendor/nid_img/".$old_imgname))) {
                        File::delete(public_path("/images/vendor/nid_img/".$old_imgname));
                    }
                    else{
                        return "something wrong";
                    }
                    $image = $request->nid_img_back;
                    $nidb_img = time().uniqid().$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/vendor/nid_img');
                    $image->move($destinationPath, $nidb_img);
                }
            }
            else{
                $nidb_img = $old_imgname;
            }

            $vendor_doc_info = VendorDocuments::findOrFail($vendor_id);
            $old_imgname = $vendor_doc_info->trade_license_doc;
            if($request->trade_l_file)
            {
                if ($request->hasFile('trade_l_file'))
                {
                    if (File::exists(public_path("/images/vendor/trade_license_img/".$old_imgname))) {
                        File::delete(public_path("/images/vendor/trade_license_img/".$old_imgname));
                    }
                    else{
                        return "something wrong";
                    }
                    $image = $request->trade_l_file;
                    $trade_l_img = time().uniqid().$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/vendor/trade_license_img');
                    $image->move($destinationPath, $trade_l_img);
                }
            }
            else{
                $trade_l_img = $old_imgname;
            }

            $old_imgname = $vendor_doc_info->vat_certification_doc;
            if($request->vat_c_file)
            {
                if ($request->hasFile('vat_c_file'))
                {
                    if (File::exists(public_path("/images/vendor/vat_img/".$old_imgname))) {
                        File::delete(public_path("/images/vendor/vat_img/".$old_imgname));
                    }
                    else{
                        return "something wrong";
                    }
                    $image = $request->vat_c_file;
                    $vat_c_img = time().uniqid().$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/vendor/trade_license_img');
                    $image->move($destinationPath, $vat_c_img);
                }
            }
            else{
                $vat_c_img = $old_imgname;
            }

            $old_imgname = $vendor_doc_info->tin_certification_doc;
            if($request->tin_c_file)
            {
                if ($request->hasFile('tin_c_file'))
                {
                    if (File::exists(public_path("/images/vendor/tin_img/".$old_imgname))) {
                        File::delete(public_path("/images/vendor/tin_img/".$old_imgname));
                    }
                    else{
                        return "something wrong";
                    }
                    $image = $request->tin_c_file;
                    $tin_c_img = time().uniqid().$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/vendor/tin_img');
                    $image->move($destinationPath, $tin_c_img);
                }
            }
            else{
                $tin_c_img = $old_imgname;
            }

            $old_imgname = $vendor_doc_info->bsti_certification_doc;
            if($request->bsti_c_file)
            {
                if ($request->hasFile('bsti_c_file'))
                {
                    if (File::exists(public_path("/images/vendor/bsti_img/".$old_imgname))) {
                        File::delete(public_path("/images/vendor/bsti_img/".$old_imgname));
                    }
                    else{
                        return "something wrong";
                    }
                    $image = $request->bsti_c_file;
                    $bsti_c_img = time().uniqid().$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/vendor/bsti_img');
                    $image->move($destinationPath, $bsti_c_img);
                }
            }
            else{
                $bsti_c_img = $old_imgname;
            }


            $strProductTypes="";
            $reqProdductType=$request->product_type;
            if(count($reqProdductType) > 0){
                $list_ptypes=[];
                for ($i=0;$i < count($reqProdductType);$i++){
                    $list_ptypes[]=$reqProdductType[$i];
                }
                $strProductTypes=implode(",",$list_ptypes);
                $strProductTypes=$strProductTypes.",";

            }

            $data=[
                'name'=> $request->name,
                'email'=> $request->email,
                'phone'=> $request->phone,
                'nid'=> $request->nid,
                'present_address'=> $request->present_address,
                'permanent_address'=> $request->permanent_address,
                'image'=> $v_img,
                'nid_front_img'=> $nidf_img,
                'nid_back_img'=> $nidb_img,
                'type_of_business'=> $request->BusinessTypeId,
                'nature_of_business'=> $request->BNatureId,
                'type_product'=> $strProductTypes,

                'password' => Hash::make($request->password),
            ];
            $bankinfoData=[
                //'vendor_id'=> $lastid,
                'account_name'=> $request->account_name,
                'account_number'=> $request->account_number,
                'routing_number'=> $request->routing_number,
                'bank_name'=> $request->bank_name,
                'branch_name'=> $request->branch_name,
                'branch_code'=> $request->branch_code,
//                'type_of_business'=> $request->BusinessTypeId,
//                'nature_of_business'=> $request->BNatureId,
//                'licence_no'=> $request->licence_no,
//                'tin_tax_id'=> $request->tin_tax_id,
//                'vat_no'=> $request->vat_no,
//                'incorporation_no'=> $request->incorporation_no,
//                'type_product'=> $request->product_type,
            ];
            $DocumentData=[
                'trade_license_no'=> $request->trade_l_no,
                'trade_license_doc'=> $trade_l_img,
                'vat_certification_no'=> $request->Vat_c_no,
                'vat_certification_doc'=> $vat_c_img,
                'tin_certification_no'=> $request->tin_c_no,
                'tin_certification_doc'=> $tin_c_img,
                'bsti_certification_no'=> $request->bsti_c_no,
                'bsti_certification_doc'=>$bsti_c_img,
                'licence_no'=> $request->licence_no,
                'tin_tax_id'=> $request->tin_tax_id,
                'vat_no'=> $request->vat_no,
                'incorporation_no'=> $request->incorporation_no,
            ];





            $result = Vendor::where('id', '=', $vendor_id)->update($data);
            $result2 = VendorBankDetails::where('vendor_id', '=', $vendor_id)->update($bankinfoData);
            $result3 = VendorDocuments::where('vendor_id', '=', $vendor_id)->update($DocumentData);

            return redirect()->back()->with('message', 'Update success');


        }





    }



    function login_as_vendor(Request $request)
    {
        session()->put('login_vendor_59ba36addc2b2f9401580f014c7f58ea4e30989d', intval($request->id));
        return redirect()->route('vendor.dashboard');

        // if(auth()->guard('vendor')->attempt(['email' =>$vendor_info->email, 'password' =>$request->password])){
        //     return redirect()->route('vendor.dashboard');
        // }
        // return redirect()->route('vendor.dashboard');
    }

    function go_to_owner()
    {
        auth()->guard('vendor')->logout();
        return redirect()->route('owner.dashboard');
    }


    //owner functions

    public function index()
    {
        return view('owner.index');
    }


    public function login()
    {
        if (Auth::guard('owner')->check()) {
            return redirect()->route('owner.dashboard');
            //   return 456;
        } else {
            return view('owner.login');
            //   return 565767;
        }

    }


    public function logout()
    {
        //dd('logout');
        auth()->guard('vendor')->logout();
        auth()->guard('owner')->logout();
        return redirect()->route('owner.login');
    }

    public function ownerlogincheck(Request $request)
    {
        // dd($request->all());
        if (auth()->guard('owner')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('owner.dashboard');

        } else {
            //dd('pass not match');
            return back();
        }
    }

    function vendor_create_submit_tushar(Request $request){
        // return $request->all();
//         echo $request->name;

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'password' => 'min:3|required_with:confirm_password|same:confirm_password',
        ]);


//        if($request->phone){
//            $vendor = Vendor::find($request->phone);
//            $uimgname = $vendor->image;
//            $nid_front_img = $vendor->nid_front_img;
//            $nid_back_img = $vendor->nid_back_img;
//            $trade_license_img = $vendor->trade_license_img;
//        }
//        else{
        // $unique_id = time().uniqid();
        // return $unique_id;

        if ($request->hasFile('user_image')) {
            $image = $request->user_image;
            $uimgname = time().uniqid().$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/vendor/vendor_img');
            $image->move($destinationPath, $uimgname);
        }
        else{
            $uimgname = null;
        }

        if($request->hasfile('nid_img_front')){
            $nid_front = $request->nid_img_front;
            $nid_front_name = time().uniqid().$nid_front->getClientOriginalExtension();
            $destinationPath = public_path('images/vendor/nid_img');
            $nid_front->move($destinationPath, $nid_front_name);
        }
        else{
            $nid_front_name = null;
        }
        if($request->hasfile('nid_img_back')){
            $nid_back = $request->nid_img_back;
            $nid_back_name = time().uniqid().$nid_back->getClientOriginalExtension();
            $destinationPath = public_path('images/vendor/nid_img');
            $nid_back->move($destinationPath, $nid_back_name);
        }
        else{
            $nid_back_name = null;
        }
//        }
        $trade_license_img = null;

//        if(get_owner_id()){
//            $created_type = 1;
//            $created_by = get_owner_id();
//            $owner_status = 1;
//            $vendor_status = 1;
//        }else{
//            $created_type = 2;
//            $created_by = active_user();
//            $vendor_status = 1;
//            $owner_status = 0;
//        }

        $data=[
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'nid_img'=> $request->nid,
            'present_address'=> $request->present_address,
            'permanent_address'=> $request->permanent_address,
            'image'=> $uimgname,
            'nid_front_img'=> $nid_front_name,
            'nid_back_img'=> $nid_back_name,
            'trade_license_img'=> $trade_license_img,
            'password' => $request->password,
        ];


//        if($request->phone > 0){
//            $vendor->update($data);
//            return response(201);
//        }
//        else{
       Vendor::create($data);

        return response(200);

//        }
//        $data['vendor_id'] = active_user();

//        if($request->current){
//            if(Store::findOrFail($request->current)->update($data)){
//                return back()->with('success','Store Updated Successfully');
//            }
//        }else{
//            if(Vendor::create($data)){
//                return back()->with('success','Vendor Created Successfully');
//            }
//        }

        // $data['password'] = bcrypt($request->password);
    }

    function vendor_create_submit(Request $request){
        // return $request->all();
//         echo $request->name;

        $validatedData = $request->validate([
            'name' => 'required|max:255',
//            'phone' => 'required|unique:vendors',
//            'email' => 'required|unique:vendors',
//            'nid' => 'required|unique:vendors',
            'password' => 'required_with:confirm_password|same:confirm_password|min:3',
        ]);


//        if($request->phone){
//            $vendor = Vendor::find($request->phone);
//            $uimgname = $vendor->image;
//            $nid_front_img = $vendor->nid_front_img;
//            $nid_back_img = $vendor->nid_back_img;
//            $trade_license_img = $vendor->trade_license_img;
//        }
//        else{
            // $unique_id = time().uniqid();
            // return $unique_id;
            //$vendorPhoto=VendorCommon::imageUpload($req,$ProfileImage,"",$Directory1,250,250);

            if ($request->hasFile('user_image')) {
                $image = $request->user_image;
                $uimgname = time().uniqid().$image->getClientOriginalExtension();


                $destinationFolder=helperAwsLocation(3)."".$uimgname;
                Storage::disk('s3')->put($destinationFolder,
                fopen($request->file('user_image'), 'r+'), 's3');

                //$destinationPath = public_path('/images/vendor/vendor_img');
                //$image->move($destinationPath, $uimgname);
            }
            else{
                $uimgname = null;
            }

            if($request->hasfile('nid_img_front')){
                $nid_front = $request->nid_img_front;
                $nid_front_name = time().uniqid().$nid_front->getClientOriginalExtension();
                $destinationPath = public_path('images/vendor/nid_img');
                $nid_front->move($destinationPath, $nid_front_name);
            }
            else{
                $nid_front_name = null;
            }
            if($request->hasfile('nid_img_back')){
                $nid_back = $request->nid_img_back;
                $nid_back_name = time().uniqid().$nid_back->getClientOriginalExtension();
                $destinationPath = public_path('images/vendor/nid_img');
                $nid_back->move($destinationPath, $nid_back_name);
            }
            else{
                $nid_back_name = null;
            }
            if ($request->hasFile('trade_l_file')) {
                $Tl_image = $request->trade_l_file;
                $Tlimgname = time().uniqid().$Tl_image->getClientOriginalExtension();
                $destinationPath = public_path('/images/vendor/trade_license_img');
                $Tl_image->move($destinationPath, $Tlimgname);
            }
            else{
                $Tlimgname = null;
            }
            if ($request->hasFile('vat_c_file')) {
                $Vat_image = $request->vat_c_file;
                $Vatimgname = time().uniqid().$Vat_image->getClientOriginalExtension();
                $destinationPath = public_path('/images/vendor/vat_img');
                $Vat_image->move($destinationPath, $Vatimgname);
            }
            else{
                $Vatimgname = null;
            }
            if ($request->hasFile('tin_c_file')) {
                $Tin_image = $request->tin_c_file;
                $Tinimgname = time().uniqid().$Tin_image->getClientOriginalExtension();
                $destinationPath = public_path('/images/vendor/tin_img');
                $Tin_image->move($destinationPath, $Tinimgname);
            }
            else{
                $Tinimgname = null;
            }
            if ($request->hasFile('bsti_c_file')) {
                $bsti_image = $request->bsti_c_file;
                $bstiimgname = time().uniqid().$bsti_image->getClientOriginalExtension();
                $destinationPath = public_path('/images/vendor/bsti_img');
                $bsti_image->move($destinationPath, $bstiimgname);
            }
            else{
                $bstiimgname = null;
            }

//            if($request->hasfile('trade_license_img')){
//                $tl_img = $request->trade_license_img;
//                $trade_license_name = time().uniqid().'.'.$tl_img->getClientOriginalExtension();
//                $destinationPath = public_path('images/vendor/trade_license_img');
//                $tl_img->move($destinationPath, $trade_license_name);
//            }
//            else{
//                $trade_license_name = null;
//            }
//        }

//        if(get_owner_id()){
//            $created_type = 1;
//            $created_by = get_owner_id();
//            $owner_status = 1;
//            $vendor_status = 1;
//        }else{
//            $created_type = 2;
//            $created_by = active_user();
//            $vendor_status = 1;
//            $owner_status = 0;
//        }
            $last_info=Vendor::max('code');
            $last_code=1000;
            if(!empty($last_info))
                $last_code=$last_info + 1;


        $strProductTypes="";
        $reqProdductType=$request->product_offer;
        if($reqProdductType==null)
            $reqProdductType=[];
        if(empty($reqProdductType))
            $reqProdductType=[];
        if(count($reqProdductType) > 0){
            $list_ptypes=[];
            for ($i=0;$i < count($reqProdductType);$i++){
                $list_ptypes[]=$reqProdductType[$i];
            }
            $strProductTypes=implode(",",$list_ptypes);
            $strProductTypes=$strProductTypes.",";

        }
        $data=[
            'name'=> $request->name,
            'code'=> $last_code,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'nid'=> $request->nid,
            'present_address'=> $request->present_address,
            'permanent_address'=> $request->permanent_address,
            'image'=> $uimgname,
            'nid_front_img'=> $nid_front_name,
            'nid_back_img'=> $nid_back_name,
            'type_of_business'=> $request->BusinessTypeId,
            'nature_of_business'=> $request->BNatureId,
            'type_product'=> $strProductTypes,
//            'trade_license_no'=> $request->trade_license_no,
//            'trade_license_img'=> $trade_license_name,
            'password' => Hash::make($request->password),
            'manual_code'=> $request->manual_code,
        ];

//        if($request->phone > 0){
//            $vendor->update($data);
//            return response(201);
//        }
//        else{
        $insertStatus=  Vendor::create($data);
            //return redirect()->route('owner.vendor_list');
//        }


        if($insertStatus==true)
        {

            $lastid=$insertStatus->id;
            $bankinfoData=[
                'vendor_id'=> $lastid,
                'account_name'=> $request->account_name,
                'account_number'=> $request->account_number,
                'routing_number'=> $request->routing_number,
                'bank_name'=> $request->bank_name,
                'branch_name'=> $request->branch_name,
                'branch_code'=> $request->branch_code,
//                'type_of_business'=> $request->BusinessTypeId,
//                'nature_of_business'=> $request->BNatureId,
//                'licence_no'=> $request->licence_no,
//                'tin_tax_id'=> $request->tin_tax_id,
//                'vat_no'=> $request->vat_no,
//                'incorporation_no'=> $request->incorporation_no,
//                'type_product'=> $strProductTypes,

            ];
            $insertStatus1= VendorBankDetails::insert($bankinfoData);

        }

        if($insertStatus1==true)
        {
            $DocumentData=[
                'vendor_id'=> $lastid,
                'trade_license_no'=> $request->trade_l_no,
                'trade_license_doc'=> $Tlimgname,
                'vat_certification_no'=> $request->Vat_c_no,
                'vat_certification_doc'=> $Vatimgname,
                'tin_certification_no'=> $request->tin_c_no,
                'tin_certification_doc'=> $Tinimgname,
                'bsti_certification_no'=> $request->bsti_c_no,
                'bsti_certification_doc'=>$bstiimgname,
                'licence_no'=> $request->licence_no,
                'tin_tax_id'=> $request->tin_tax_id,
                'vat_no'=> $request->vat_no,
                'incorporation_no'=> $request->incorporation_no,
            ];
            $insertStatus2= VendorDocuments::insert($DocumentData);
            return redirect()->route('owner.vendor_list');
        }





//        $data['vendor_id'] = active_user();

//        if($request->current){
//            if(Store::findOrFail($request->current)->update($data)){
//                return back()->with('success','Store Updated Successfully');
//            }
//        }else{
//            if(Vendor::create($data)){
//                return back()->with('success','Vendor Created Successfully');
//            }
//        }

        // $data['password'] = bcrypt($request->password);
    }

    function owner_store_list(Request $request){
        $stores = Store::with('get_vendor_info:id,name');
        $vendors = Vendor::where('status',1)->get();
        if($request->vendor){
            $stores = $stores->where('vendor_id',$request->vendor);
        }
        $stores = $stores->get();
        return view('owner.store_releted.store_list', compact('stores', 'vendors'));
    }

    //store type change function
    function owner_type_change(Request $request){
        $store = Store::findOrFail($request->id);

        if($store->type == 1){
            $type = 2;
        }else{
            $type = 1;
        }
        if($store->update(['type' => $type])){
            return back()->with('success', "Store Setting Is Changed Successfully");
        }
    }
}
