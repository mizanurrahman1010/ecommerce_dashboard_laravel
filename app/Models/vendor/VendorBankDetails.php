<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankDetails extends Model
{
    protected $fillable=["vendor_id","account_name"];
    use HasFactory;
}
