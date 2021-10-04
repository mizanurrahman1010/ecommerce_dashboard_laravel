<?php

namespace Database\Seeders;

use App\Models\Setting\WarrentyMonthYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederWarrentyMonthYear extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("warrenty_month_years")->truncate();
        $years=[];
        for($i=1;$i <= 50;$i++){
            array_push($years,["name" => $i,"type" => 1]);
        }
        WarrentyMonthYear::insert($years);

        $years=[];
        for($i=1;$i <= 12;$i++){
            array_push($years,["name" => $i,"type" => 2]);
        }
        WarrentyMonthYear::insert($years);
    }
}
