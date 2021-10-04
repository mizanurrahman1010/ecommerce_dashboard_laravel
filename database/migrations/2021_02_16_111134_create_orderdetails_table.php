<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->id();

            $table->integer('product_id')->nullable();
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('color_id')->nullable();
            $table->integer('size_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('order_id')->nullable();

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
        Schema::dropIfExists('orderdetails');
    }
}
