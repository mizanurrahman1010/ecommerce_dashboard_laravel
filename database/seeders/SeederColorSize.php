<?php

namespace Database\Seeders;

use App\Models\ColorSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederColorSize extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("color_sizes")->truncate();
        ColorSize::insert([
            ["name" => "Def Color","parent_id"=>null,"type" => 1],
            ["name" => "No Color","parent_id"=>1,"type" => 1],
            ["name" => "Def Size","parent_id"=>null,"type" => 2],
            ["name" => "No Size","parent_id"=>3,"type" => 2],
        ]);
    }
}
