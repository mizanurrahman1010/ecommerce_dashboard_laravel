<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCasWisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cas_wises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pp_id');
            //$table->foreign('pp_id')->references('id')->on('product_prices')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('color_id');
            //$table->foreign('color_id')->references('id')->on('color_sizes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('size_id');
            //$table->foreign('size_id')->references('id')->on('color_sizes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('quantity')->nullable()->default(0);
            //$table->string('use_color_id')->nullable()->default(0);
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
        Schema::dropIfExists('product_cas_wises');
    }
}
