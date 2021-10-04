<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederVendor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("vendors")->truncate();
        Vendor::insert([
            [
                "password" => '$2y$12$kTep2IsUr8ZajTLN0Uoaqefe71OLOo4ckwxZAUke1g2uAEBdXh8ry',
                "email" => "amin@gmail.com",
                "name" => "Test Vendor",
                "code" => 1000,
                
            ],
        ]);
    }
}
