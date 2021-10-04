<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('total')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('sub_total')->nullable();
            $table->string('address')->nullable();
            $table->string('note')->nullable();
            $table->string('mobile')->nullable();
            $table->tinyInteger('status');
            $table->timestamp('pending_at')->nullable();
            $table->timestamp('confirm_at')->nullable();
            $table->timestamp('processing_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
