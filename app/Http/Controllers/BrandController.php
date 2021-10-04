<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Pusher\Pusher;

class BrandController extends Controller
{
    function index(Request $request){

        //$brands = Brand::get();
        $brands = Brand::getBrandList();
        return view('owner.product.brand', compact('brands'));
    }

    function store(Request $request){
        // return $request->all();

        $this->validate($request, [
            'aksfileupload' => 'required',
            'aksfileupload.*' => 'image'
        ],[
            'aksfileupload.required' => 'Brand Image Must Need'
        ]);

        $file = $request->aksfileupload;


        if ($request->hasFile('aksfileupload'))
            {
                $image = $request->aksfileupload;
                $uimgname = time().uniqid().$image->getClientOriginalExtension();
                $des=helperAwsLocation(4)."".$uimgname;;
                uploadImageToS3($image,$des);
            }
        else
            {
                $uimgname = null;
            }

        Brand::create([
            'name' => $request->brand_name,
            'slug' =>  \Str::slug($request->brand_name),
            'image' => $uimgname,
            'status' => 1
        ]);
        return back()->with('success', 'Brand Added Successfully...');

    }

    function get_info(Request $request){
        return Brand::find($request->id);
    }


    function delete(Request $request){
        $brandimage = Brand::find($request->id);
        $brandimagename =  $brandimage->imagename;

        $currentimg = public_path("/images/product_images/".$brandimagename);

        if (File::exists(public_path("images/brand/".$brandimagename))) {
                File::delete(public_path("images/brand/".$brandimagename));
            }
            else{
                return "something wrong";
            }
        $brandimage->delete();
        return back()->with('success', 'Brand Deleted!');
    }

  //details image update

    function edit(Request $request){

        // return $request->all();
        $brandimage = Brand::findOrFail($request->id);
        $currentimgname = $brandimage->image;



        if($request->newimage){
            $this->validate($request, [
                'newimage' => 'required',
                'newimage.*' => 'image',
                'brand_name' => 'required',
            ]);
            if ($request->hasfile('newimage')) {

                if(!empty($currentimgname)){
                    $destinationFolder=helperAwsLocation(4)."".$currentimgname;
                    Storage::disk('s3')->delete($destinationFolder);
                }
                $image = $request->newimage;
                $v_img = time().uniqid().$image->getClientOriginalExtension();
                $destinationFolder=helperAwsLocation(4)."".$v_img;
                Storage::disk('s3')->put($destinationFolder,
                    fopen($request->file('newimage'), 'r+'), 's3');

//                $image = $request->newimage;
//                $uimgname = time().rand(1,100).'.'.$image->getClientOriginalExtension();
//                $destinationPath = public_path('/images/brand');
//                $image->move($destinationPath, $uimgname);

                $brandimage->update([
                    'image' => $v_img,
                    'name' => $request->brand_name,
                    'descriptions' => $request->description
                ]);
                return back()->with('success','Brand Image Updated Successfully');
            }
        }
        else{

            // return 123;
            $brandimage->update([
                'name' => $request->brand_name,
                'descriptions' => $request->description
            ]);

            return back()->with('success','Brand Info Updated Successfully');
        }
    }
    function status_update(Request $request){

        $status=1;
        $info = Brand::findOrFail($request->id);
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

    function search_brand(Request $request){
        $search_item = $request->searchTerm;
        $brand_names = Brand::select('id','name')
        ->where('name','LIKE','%'.$search_item.'%')
        ->orderBy('name','asc')
        ->limit(5)
        ->get();
        $data = array();

        foreach($brand_names as $bn){
            $data[] = array("id"=>$bn['id'], "text"=>$bn['name']);
        }
        echo json_encode($data);
    }
}
