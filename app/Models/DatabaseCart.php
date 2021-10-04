<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ColorSize;

class DatabaseCart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function get_product_info(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function get_color_name(){
        return $this->belongsTo(ColorSize::class, 'color_id');
    }

    public function get_size_name(){
        return $this->belongsTo(ColorSize::class, 'size_id');
    }
}
