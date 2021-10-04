<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Orderdetail;
use App\Models\OrderLog;

class Order extends Model
{
    use HasFactory;
    protected $guarded;

    public function get_user_info(){
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function get_order_details(){
        return $this->hasMany(Orderdetail::class, 'order_id');
    }

    public function get_order_log(){
        return $this->hasMany(OrderLog::class, 'order_id');
    }
}
