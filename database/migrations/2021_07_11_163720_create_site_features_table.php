<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_features', function (Blueprint $table) 
        {
            $table->id();
            $table->string("name");
            $table->string("route")->unique();
            $table->text("description")->nullable();
            $table->text("images")->nullable();
            $table->tinyInteger("type_id")->default(1);
            $table->smallInteger("sort_id")->default(9999);
            $table->tinyInteger("status")->default(1)->comment("1=active,2=inactive");
            $table->softDeletes();
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
        Schema::dropIfExists('site_features');
    }
}
