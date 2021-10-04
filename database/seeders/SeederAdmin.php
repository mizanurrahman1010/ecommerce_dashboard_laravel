<?php

namespace Database\Seeders;

use App\Models\Owner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("owners")->truncate();
        Owner::insert([
            ["password" => '$2y$12$kTep2IsUr8ZajTLN0Uoaqefe71OLOo4ckwxZAUke1g2uAEBdXh8ry',"email" => "amin@gmail.com"],
        ]);
    }
}
