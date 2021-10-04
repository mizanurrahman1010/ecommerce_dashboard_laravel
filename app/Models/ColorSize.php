<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorSize extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['name','parent_id','type','status','created_by','updated_by','deleted_by','deleted_at','created_at','updated_at'];

    public function get_child(){
        return $this->hasMany('App\Models\ColorSize','parent_id','id');
    }
}
