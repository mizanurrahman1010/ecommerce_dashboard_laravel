<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            //$table->string('barcode')->nullable()->index();
            $table->string('name')->index();
            $table->bigInteger('code')->uniqid();
            $table->string('slug')->unique();
            $table->integer('owner_id')->default(0);
            //$table->integer('min_sell_qty')->nullable();
            //$table->string('weight');
            //$table->tinyInteger('stock_maintain_status')->default(1)->comment("1=maintain,2=not maintain");
            $table->text('unit')->nullable();
            $table->integer('department_id')->index();
            $table->integer('category_id')->default(0)->index();
            $table->integer('sub_category_id')->default(0)->index();
            $table->integer('sub_sub_category_id')->default()->index();
            // $table->integer('stock_quantity')->nullable();
            $table->integer('size_group')->default(0);
            $table->integer('color_group')->default(0);
            $table->integer('brand_id')->nullable()->index();
            $table->integer('origin')->default(0);
            $table->string('description')->nullable();
            $table->string('specification')->nullable();
            $table->integer('highlight')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('created_by')->comment("ID of owner table or vendor table");
            $table->tinyInteger('created_type')->comment("1 = Owner, 2 = Vendor");
            $table->tinyInteger('vendor_status')->default(0)->index();
            $table->tinyInteger('owner_status')->default(0)->index();
            $table->tinyInteger('status')->default(1)->comment("1=active,2=inactive")->index();
            
            $table->timestamps();
            $table->softDeletes();

            //$table->string("offers_item")->nullable();
            // $table->string('min_unit')->nullable();
            //$table->integer('vendor_id')->nullable()->index();
            // $table->integer('store_id')->nullable();
            // $table->integer('price')->nullable();
            // $table->integer('regular_price')->nullable();
            // $table->integer('discount')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
