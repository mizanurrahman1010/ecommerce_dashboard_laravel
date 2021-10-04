<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWarrentiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_warrenties', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id");
            $table->integer("store_id");
            $table->integer("year")->default(0);
            $table->integer("month")->default(0);
            $table->integer("day")->default(0);
            $table->text("notes")->nullable();
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
        Schema::dropIfExists('product_warrenties');
    }
}
