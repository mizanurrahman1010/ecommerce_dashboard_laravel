<?php

namespace App\Http\Controllers;

use App\Models\CampaignType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Campaign;
use App\Models\CampaignDetails;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Collection;

class CampaignController extends Controller
{

    //campaign Type Show
    function campaign_type_show(){
        $campaign_type = CampaignType::get();
        return view('owner.campaign.campaign_type', compact('campaign_type'));
    }

    //campaign Create
    function campaign_type_create(Request $request){
        $this->validate($request, [
            'aksfileupload' => 'required',
            'aksfileupload.*' => 'image',
            'name' => 'required'
        ],[
            'aksfileupload.required' => "Image Is Required"
        ]);

        $file = $request->aksfileupload;

        if($request->hasfile('aksfileupload')){

            $imgname = time().rand(1,100).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images/campaign_type'), $imgname);

            CampaignType::create([
                'name' => $request->name,
                'remarks' => $request->remarks,
                'image' => $imgname,
                'status' => 1
            ]);
            return back()->with('success', 'Campaign Group Added Successfully...');
        }
    }

    // campaign type edit

    function campaign_type_edit(Request $request){
        return CampaignType::find($request->id);
    }

    // campaign type update
    function campaign_type_update(Request $request){

        // return $request->all();
        // exit();

        $curimage = CampaignType::findOrFail($request->id);
        $currentimgname = $curimage->image;

        if($request->newimage){
            $this->validate($request, [
                'newimage' => 'required',
                'newimage.*' => 'image',
                'name' => 'required',
            ]);

            if ($request->hasfile('newimage')) {

                if (File::exists(public_path("images/campaign_type/".$currentimgname))) {
                    File::delete(public_path("images/campaign_type/".$currentimgname));
                }
                else{
                    return "something wrong";
                }

                $image = $request->newimage;
                $uimgname = time().rand(1,100).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/campaign_type');
                $image->move($destinationPath, $uimgname);

                $curimage->update([
                    'image' => $uimgname,
                    'name' => $request->name,
                    'remarks' => $request->remarks
                ]);
                return back()->with('success','Campaign Updated Successfully');
            }
        }
        else{

            // return 123;
            $curimage->update([
                'name' => $request->name,
                'remarks' => $request->remarks
            ]);

            return back()->with('success','Campaign Updated Successfully');
        }
    }

    // campaign type status change

    function campaign_type_status(Request $request){
        $campaign_type_status = CampaignType::find($request->id);
            if($campaign_type_status->status == 0){
                if($campaign_type_status->update(['status' => 1])){
                    return back()->with('success','Campaign Type Status Changed Successfully');
                }
            }
            else{
                if($campaign_type_status->update(['status' => 0])){
                    return back()->with('success','Campaign Type Status Changed Successfully');
                }
            }

    }


    //campaign Type Show
    function campaign_show(){
        $camp_types = CampaignType::select('id','name')->get();
        $campaigns = Campaign::with('get_campaign_type:id,name')->get();
        return view('owner.campaign.campaign', compact('campaigns','camp_types'));
    }

    //campaign Create
    function campaign_create(Request $request){
        // return $request->input();
        $this->validate($request, [
            'aksfileupload' => 'required',
            'aksfileupload.*' => 'image',
            'campaign_type' => 'required',
            's_time' => 'required',
            'e_time' => 'required',
            'delivery_info' => 'required',
        ],[
            'aksfileupload.required' => 'Image Is Required'
        ]);

        $file = $request->aksfileupload;
            // return $file;
        if($request->hasfile('aksfileupload')){
            $imgname = time().rand(1,100).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images/campaigns'), $imgname);

            Campaign::create([
                'campaign_type' => $request->campaign_type,
                'name' => $request->name,
                'image' => $imgname,
                'start_time' =>$request->s_time,
                'end_time' =>$request->e_time,
                'delivery_info' => $request->delivery_info,
                'remarks' => $request->remarks,
                'status' => 0
            ]);
            return back()->with('success', 'Campaign Added Successfully...');
        }
    }

    // campaign type edit

    function campaign_edit(Request $request){
        return Campaign::findOrFail($request->id);
    }

    // campaign type update
    function campaign_update(Request $request){

        $curimage = Campaign::findOrFail($request->id);
        $currentimgname = $curimage->image;

        if($request->newimage){
            $this->validate($request, [
                'newimage' => 'required',
                'newimage.*' => 'image',
                'name' => 'required',
                'campaign_type' => 'required',
                's_time' => 'required',
                'e_time' => 'required',
                'delivery_info' => 'required',
            ]);

            if ($request->hasfile('newimage')) {

                if (File::exists(public_path("images/campaigns/".$currentimgname))) {
                    File::delete(public_path("images/campaigns/".$currentimgname));
                }
                else{
                    return "something wrong";
                }

                $image = $request->newimage;
                $uimgname = time().rand(1,100).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/images/campaigns');
                $image->move($destinationPath, $uimgname);

                $curimage->update([
                    'image' => $uimgname,
                    'name' => $request->name,
                    'campaign_type' => $request->campaign_type,
                    'start_time' => $request->s_time,
                    'end_time' => $request->e_time,
                    'delivery_info' => $request->delivery_info,
                    'remarks' => $request->remarks,

                ]);
                return back()->with('success','Campaign Updated Successfully');
            }
        }
        else{

            // return 123;
            $curimage->update([
                'name' => $request->name,
                'campaign_type' => $request->campaign_type,
                'start_time' => $request->s_time,
                'end_time' => $request->e_time,
                'delivery_info' => $request->delivery_info,
                'remarks' => $request->remarks,
            ]);

            return back()->with('succes','Campaign Updated Successfully');
        }
    }

    // campaign type status change

    function campaign_status(Request $request){
        $campaign_status = Campaign::findOrFail($request->id);
        if($campaign_status->status == 0){
            if($campaign_status->update(['status' => 1])){
                return back()->with('success','Campaign Status Changed Successfully');
            }
        }
        else{
            if($campaign_status->update(['status' => 0])){
                return back()->with('success','Campaign Status Changed Successfully');
            }
        }
    }

    //product add to campaign

    function campaign_product_add(Request $request){
        $c_ids = CampaignDetails::select('campaign_id')->groupBy('campaign_id')->get();

        $campaigns = Campaign::select('id','name')
            ->whereNotIn('id', $c_ids)
            ->where('status',1)
            ->get();
        return view('owner.Campaign.product_assign_to_campaign', compact('campaigns'));
    }

    function product_add_to_campaign(Request $request){
        // return $request->all();

        $campaign_id = $request->campaign_id;
        $data = json_decode($request->list);


        $same = [];
        foreach($data as $d){
            $com = $d->sid.'-'.$d->pid;
            array_push($same, $com);
        }

        $duplicates = array_diff_key($same, array_unique($same));
        if($duplicates){
            return false;
        }else{
            foreach($data as $insert){
                CampaignDetails::create([
                    'campaign_id' => $campaign_id,
                    'product_id' => $insert->pid,
                    'store_id' => $insert->sid,
                    'cashback' => $insert->cb,
                    'price' => $insert->price,
                    'discount' => $insert->dis
                ]);
            }
            return 'success';
        }
        // $message = [];

        // foreach($data as $insert){
        //     $status = null;
        //     $status = CampaignDetails::where('campaign_id', $campaign_id)
        //         ->where('product_id', $insert->pid)
        //         ->where('store_id', $insert->sid)
        //         ->first();
        //     if($status){
        //         $msg = Product::find($status->product_id)->name;
        //         array_push($message, $msg);
        //     }
        // }
    }

    function campaign_product_edit(Request $request){
        // return $request->id;
        $campaign_name = Campaign::select('id','name')->findOrFail($request->id);
        // return $campaign_name;
        $products = CampaignDetails::where('campaign_id', $request->id)
            ->with('get_campaign_name:id,name')
            ->with('get_store_name:id,name')
            ->with('get_product_name:id,name')
            ->get();
        return view('owner.Campaign.product_edit_to_campaign', compact('campaign_name','products'));
    }

    function product_update_to_campaign(Request $request){
        // return $request->all();

        $campaign_id = $request->campaign_id;
        $data = json_decode($request->list);

        // $collection = collect($data);

        $same = [];
        foreach($data as $d){
            $com = $d->sid.'-'.$d->pid;
            array_push($same, $com);
        }

        // return array_unique($same);
        $duplicates = array_diff_key($same, array_unique($same));
        if($duplicates){
            return false;
        }
        else{
            $exist = [];
            foreach($data as $insert){
                array_push($exist, $insert->row_id);
                if($insert->row_id != ""){
                    CampaignDetails::find($insert->row_id)->update([
                        'campaign_id' => $campaign_id,
                        'product_id' => $insert->pid,
                        'store_id' => $insert->sid,
                        'cashback' => $insert->cb,
                        'price' => $insert->price,
                        'discount' => $insert->dis
                    ]);
                }
                else{
                    $id = CampaignDetails::create([
                        'campaign_id' => $campaign_id,
                        'product_id' => $insert->pid,
                        'store_id' => $insert->sid,
                        'cashback' => $insert->cb,
                        'price' => $insert->price,
                        'discount' => $insert->dis
                    ]);
                    array_push($exist, $id->id);
                }

            }
        }

        CampaignDetails::where('campaign_id', $campaign_id)->whereNotIn('id',$exist)->delete();
        return 'success';
    }

    function campaigns_details(Request $request){

        $cam_details = CampaignDetails::orderBy('campaign_id')
        ->with('get_product_name:id,name','get_store_name:id,name','get_campaign_name:id,name')
        ->get();
        // return $cam_details;
        return view('owner.Campaign.details', compact('cam_details'));
    }
}
