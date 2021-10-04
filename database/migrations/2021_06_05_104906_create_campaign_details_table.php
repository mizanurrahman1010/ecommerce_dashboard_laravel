<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->comment("ID from campaign table");
            $table->unsignedBigInteger('product_id')->comment("ID from product table");
            $table->unsignedBigInteger('store_id')->comment("ID from store table");
            $table->Integer('cashback');
            $table->Integer('price');
            $table->Integer('discount');
            //$table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade')->onUpdate('cascade');
            //$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            //$table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('campaign_details');
    }
}
