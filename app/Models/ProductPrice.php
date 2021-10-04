<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductCasWise;
use App\Models\Store;
use GuzzleHttp\Psr7\Request;
use App\Models\Product;

class ProductPrice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function get_store_name(){
        return $this->belongsTo(Store::class,'store_id');
    }
    // public function get_quantity_store_wise(){
    //     return $this->hasMany(ProductCasWise::class,'pp_id');
    // }


    public function get_product_info(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function get_product_qty(){
        return $this->hasMany(ProductCasWise::class,'pp_id','id');
    }
}
