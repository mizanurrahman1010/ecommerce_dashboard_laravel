<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductPrice;
use App\Models\ColorSize;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded;
//    public function setNameAttribute($value)
//    {
//        $this->attributes['name'] = $value;
//        $this->attributes['slug'] = Str::slug($value);
//    }
    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist');
    }

    public function get_category(){
      return $this->belongsTo('App\Models\Category','category_id','id');
    }
    public function get_department(){
        return $this->belongsTo('App\Models\Category','department_id','id');
    }
    public function get_sub_category(){
        return $this->belongsTo('App\Models\Category','sub_category_id','id');
    }
    public function get_sub_sub_category()
    {
        return $this->belongsTo('App\Models\Category','sub_sub_category_id','id');
    }
    public function get_price_store_wise(){
        return $this->hasMany(ProductPrice::class);
    }

    public function get_color_group(){
        return $this->hasOne(ColorSize::class,'id','color_group');
    }

    public function get_size_group(){
        return $this->hasOne(ColorSize::class,'id','size_group');
    }

    public function get_colors(){
        return $this->hasMany(ColorSize::class,'parent_id','color_group');
    }

    public function get_sizes(){
        return $this->hasMany(ColorSize::class,'parent_id','size_group');
    }

    public function get_vendor_name(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
