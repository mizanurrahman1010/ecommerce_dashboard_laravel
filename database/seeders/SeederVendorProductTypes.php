<?php

namespace Database\Seeders;

use App\Models\vendor\VendorProductType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederVendorProductTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("vendor_product_types")->truncate();
        VendorProductType::insert([
            [
                'name' => 'Local',
            ],
            [
                'name' => 'Foreign',
            ],
            [
                'name' => 'Other(Specify)',
            ]]
        );
    }
}
