<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignDetails extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function get_product_name(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function get_store_name(){
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function get_campaign_name(){
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }


}
