<?php

namespace App\Http\Controllers;

use App\Models\Settings\SiteFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OfferController extends Controller
{
    //
    public function deleteImage(Request $req)
    {
        $id=$req->id;
        $img=$req->img;
        $info=validOfferImages($id,$img,2);
        $upImg="";
        if(count($info["imagesAR"]) > 0)
        {
            $upImg=implode(",",$info["imagesAR"]).",";  
        }
        $info=SiteFeature::find($id);
        $info->images=$upImg;
        $info->save();
        return ["status" => 1,"msg" => "Success"];
    }
    public function offerIndex(Request $req){

        $list=SiteFeature::get();
        $update_info=[];
        if(!empty($req->id) && !empty($req->pid)){
            $info=validOfferImages($req->id,$req->pid);
            if($info["status"] == 0)
                return redirect('owner/offer/index');
            $update_info=$info;    
        }
        else if(!empty($req->id)){
            $isExist=SiteFeature::find($req->id);
            if(!empty($isExist->id)){
                $update_info=["id" => $req->id ,"pid" => "","status" => 1,"info" => $isExist];
            }
        }
        $offers=getSiteOffers();
        return view("owner.offer.create",compact("offers","update_info",'list'));
    }
    public function index(Request $req)
    {

        $list=SiteFeature::get();
        $type_id=0;
        if(!empty($req->offer_type))
            $type_id=$req->offer_type;

        $offers=SiteFeature::
            where("status",1)
            ->orderBy("sort_id","asc")
            ->where(function($q) use ($type_id){
                if(!empty($type_id))
                    $q->where("id",$type_id);
            })
            ->get();
        
        return view("owner.offer.index",compact("offers","list"));
    }
    public  function save(Request $req)
    {
        // $validated = $req->validate([
        //     'offer_id' => 'required',
        //     'images' => 'required',
        // ]);
        $offer_images=[];
        $def_offer_images="";
        $offer_id=$req->offer_id;


        

        
        $status=0;$msg="Some thing went wrong!!";
        
        if($req->hasfile('images')){
            if(isset($req->update_id)){
                $info=validOfferImages($req->update_id,$req->update_img,2);
                $upImg="";
    
                if(count($info["imagesAR"]) > 0){
                    $upImg=implode(",",$info["imagesAR"]).",";
                    
                }
                $info=SiteFeature::find($req->update_id);
                $info->images=$upImg;
                $info->save();
            }
            foreach($req->file('images') as $file)
            {
                $imgname = time().rand(1,100).'.'.$file->getClientOriginalExtension();
                $des=helperAwsLocation(8)."".$imgname;
                uploadImageToS3($file,$des);
                $offer_images[]=$imgname;
            }
            if(count($offer_images) > 0)
            {
                $def_offer_images=implode(",",$offer_images).",";
            }
        }
        $route_name=$req->name;
        if($offer_id > 0)
            {
                $info=SiteFeature::find($offer_id);
                $route_name=$info->name;
            }
        else
            $info=new SiteFeature();
        
        $info->status=$req->status;
        if(empty($offer_id))
            $info->name=$req->name;

        $info->sort_id=$req->sort_id;
        
        if(!empty($info->images))
            $info->images=$info->images."".$def_offer_images;
        else
            $info->images=$def_offer_images;    

        $info->route=\Str::slug($route_name);
        $info->save();
        $status=1;$msg="Success";
        return redirect()->back()->with('message', $msg);
        
        //return ["status" => $status,"msg" => $msg];
    }
}
