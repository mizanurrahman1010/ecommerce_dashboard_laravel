<?php

namespace Database\Seeders;

use App\Models\vendor\VendorBusinessNature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SeederVendorBusinessNature extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("vendor_business_natures")->truncate();

        VendorBusinessNature::insert([
            [
                'name' => 'Manufacturer',
            ],
            [
                'name' => 'Distributor',
            ],
            [
                'name' => 'Trader',
            ],
            [
                'name' => 'Importer',
            ],
            [
                'name' => 'Whole Seller',
            ],
            [
                'name' => 'Other(Specify)',
            ]]
        );
    }
}
