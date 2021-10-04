<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $fillable  = ['product_id','customer_id','created_at','updated_at'];

    public function products(){
        return $this->belongsTo('App\Product', 'product_id');
    }
}
