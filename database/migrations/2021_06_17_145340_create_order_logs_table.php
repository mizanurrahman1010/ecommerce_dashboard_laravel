<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('Id from Order Table');
            $table->string('status_id')->comment("2 = confirmed, 3 = processing, 3 = delivered");
            $table->string('message');
            $table->unsignedBigInteger('done_by')->comment('id from owner table');
            //$table->foreign('done_by')->references('id')->on('owners')->onUpdate('cascade')->onDelete('cascade');
            //$table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('order_logs');
    }
}
