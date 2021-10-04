<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('name_local')->nullable();
            $table->integer('code')->default(0);
            $table->string('manual_code')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable()->unique();
            $table->integer('nid')->nullable()->unique();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('image')->nullable();
            $table->string('nid_front_img')->nullable();
            $table->string('nid_back_img')->nullable();
            // $table->text('trade_license_no')->nullable();
            // $table->string('trade_license_img')->nullable();
            $table->text('password')->nullable();
            $table->integer('type_of_business')->nullable();
            $table->integer('nature_of_business')->nullable();
            $table->integer('type_product')->nullable();
            $table->boolean('status')->default(1)->comment("1=active,2=inactive");

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
        Schema::dropIfExists('vendors');
    }
}
