<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->default(0);
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('product_id')->comment("ID From Product Table");
            $table->unsignedBigInteger('store_id')->comment("ID from Store Table");
            $table->integer('price');
            $table->integer('price_status')->default('1')->comment('1=Price show, 2=Price Hide');
            $table->integer('discount')->default(0);
            $table->integer('product_quantity')->default(0)->nullable();
            $table->integer('stock_available_status')->default('1')->comment('1=Stock show, 2=stock hide');
           // $table->integer('quantity')->nullable();
            $table->integer('warranty_months')->comment("Month");
            $table->tinyInteger('approve_status')->comment("1 = Product/Pricing is approved By admin, 0 Product Is not approved yet");
            $table->string('item_offer');
            $table->integer('minimum_sell_unit');
            $table->string('sku');
            $table->integer('vat')->default(0);
            $table->integer('status')->comment("1=active, 2=inactive");
            $table->tinyInteger('cur_status')->comment("0 = Created, 1 Update");
            $table->tinyInteger('created_by')->comment("ID of owner table or vendor table");
            $table->tinyInteger('created_type')->comment("1 = Owner, 2 = Vendor");
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_prices');
    }
}
