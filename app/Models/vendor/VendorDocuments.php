<?php

namespace App\Models\vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDocuments extends Model
{
    protected $fillable=["vendor_id"];
    use HasFactory;
}
