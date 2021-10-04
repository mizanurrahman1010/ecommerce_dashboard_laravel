<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Store;

class Vendor extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    protected $guarded = ['created_at','updated_at'];

    public function get_stores(){
        return $this->hasMany(Store::class, 'vendor_id');
    }

    public static function getVendorList()
    {
        $vid=session()->get('vendor_id');
        $name=""; $phone=""; $email=""; $status=0; $bid=0;
        if(!empty($_GET["name"]))
            $name=$_GET["name"];
        if(!empty($_GET["phone_no"]))
            $phone=$_GET["phone_no"];
        if(!empty($_GET["email_no"]))
            $email=$_GET["email_no"];


        if(isset($_GET["StatusTypeId"]))
            $status=$_GET["StatusTypeId"];

        $info=Vendor::where(function($q) use($name,$phone,$email,$status){
            //$q->where("id",2);
            if(!empty($name))
                $q->where("name","like",'%'.$name.'%');
            if(!empty($phone))
                $q->where("phone",$phone);
            if(!empty($email))
                $q->where("email",$email);
            if(!empty($status))
                $q->where("status",$status);
        })->orderBy("id","asc")->paginate(10)->appends(request()->input());

        return $info;

//        $info=VendorProduct::where(function($q) use($vid,$sid,$bid,$status){
//            $q->where("vendor_id",$vid);
//            if(!empty($sid))
//                $q->where("store_id",$sid);
//            if(!empty($bid))
//                $q->where("brand_id",$bid);
//            if(!empty($status))
//                $q->where("status",$status);
//        })->orderBy("id","desc")->orderBy("ledger_title","asc")->paginate(16)->appends(request()->input());
//
//        return $info;

    }
}
