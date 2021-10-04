<?php

namespace Database\Seeders;

use App\Models\vendor\VendorBusinessTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SeederVendorBusinessTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("vendor_business_types")->truncate();
        VendorBusinessTypes::insert([
                [
                    'name' => 'Corporate/Limited',
                ],
                [
                    'name' => 'Partnership',
                ],
                [
                    'name' => 'Proprietorship',
                ],
                [
                    'name' => 'Other(Specify)',
                ]]

        );
    }
}
