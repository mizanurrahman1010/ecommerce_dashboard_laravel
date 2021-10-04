<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->comment("ID from Vendor ID");
            $table->integer('code')->default(0);
            $table->text("name")->comment("Store Name");
            $table->text("address");
            $table->string("contact");
            $table->string("user_name");
            $table->string("password");
            $table->string('image')->comment("store image");
            $table->string('Longitude');
            $table->string('latitude');
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=deactive');
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
        Schema::dropIfExists('stores');
    }
}
