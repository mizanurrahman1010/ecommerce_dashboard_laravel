<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings\SiteFeature;
use Illuminate\Support\Facades\DB;

class SeederSiteFeatures extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("site_features")->truncate();
        SiteFeature::insert([
            ['name' => 'Great Savings',"type_id" => 1,"route" => ''],
            ['name' => 'Half Price Offers',"type_id" => 1,"route" => ''],
            ['name' => 'Buy More Save More',"type_id" => 1,"route" => ''],
            ['name' => 'Buy 1 Get1 Offers',"type_id" => 1,"route" => ''],
            ['name' => 'Hot Offers',"type_id" => 1,"route" => ''],
            ['name' => 'Voucher Offer',"type_id" => 2,"route" => ''],
            ['name' => 'Our Own Products',"type_id" => 1,"route" => ''],
            ['name' => 'Campaign',"type_id" => 3,"route" => ''],
            ['name' => 'Home Applience',"type_id" => 4,"route" => ''],
            ['name' => 'Grocery',"type_id" => 5,"route" => ''],
            ['name' => 'Voucher Shop',"type_id" => 6,"route" => ''],
            ['name' => 'Prime Shop',"type_id" => 6,"route" => ''],
            ['name' => 'Pretty Atom',"type_id" => 6,"route" => ''],
            ['name' => 'Pretty Offers',"type_id" => 7,"route" => ''],
            ]
        );
    }
}
