<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrentyMonthYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warrenty_month_years', function (Blueprint $table) {
            $table->id();
            $table->integer("name");
            $table->tinyInteger("status")->default(1)->comment("1=active,2=inactive");
            $table->tinyInteger("type")->default(1)->comment("1=year,2=momth");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warrenty_month_years');
    }
}
