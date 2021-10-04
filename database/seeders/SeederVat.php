<?php

namespace Database\Seeders;

use App\Models\Settings\VatList;
use App\Models\Settings\VatTax;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederVat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("vat_taxes")->truncate();
        VatTax::insert([
                ['name' => 'vat 0%',"value" => 0],
                ['name' => 'vat 5%',"value" => 5],
                ['name' => 'vat 7.5%',"value" => 7.5],
                ['name' => 'vat 10%',"value" => 10],
                ['name' => 'vat 15%',"value" => 15],

            ]
        );
    }
}
