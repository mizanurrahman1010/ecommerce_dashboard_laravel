<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignType;

class Campaign extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function get_campaign_type(){
        return $this->belongsTo(CampaignType::class, 'campaign_type');
    }
}
