<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Vendor;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function get_vendor_info(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
