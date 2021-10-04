<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetailImages extends Model
{
    protected $fillable = ['productid','imagename','status','created_at','updated_at'];

    // public function setImagenameAttribute($value)
    // {
    //     $this->attributes['imagename'] = json_encode($value);
    // }
}
