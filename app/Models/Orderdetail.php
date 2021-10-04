<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Orderdetail extends Model
{
    protected $guarded = ['created_at','updated_at'];


    public function get_product_name(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
