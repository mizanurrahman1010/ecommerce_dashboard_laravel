<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;


class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];
    use HasFactory;

    public static function getBrandList()
    {
        $name="";
        $status=1;
        if(!empty($_GET["name"]))
            $name=$_GET["name"];
        if(isset($_GET["StatusTypeId"]))
            $status=$_GET["StatusTypeId"];

        $info=Brand::where(function($q) use($name,$status){
            //$q->where("id",2);
            if(!empty($name))
                $q->where("name","like",'%'.$name.'%');
            if(!empty($status))
                $q->where("status",$status);
        })->orderBy("id","asc")->paginate(20)->appends(request()->input());

        return $info;


    }

}
