<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Settings\ProductUnits;
class SeederProductUnits extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("product_units")->truncate();
        ProductUnits::insert([
            ["name" => "Pices"],
            ["name" => "KG"],
            ["name" => "Gram"],
            ["name" => "Inch"],
        ]);
    }
}
