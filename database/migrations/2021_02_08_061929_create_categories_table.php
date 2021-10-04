<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('parent_id')->nullable();
            $table->string('slug');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger("home_page_show_status")->default(1)->comment("1=show,2=hide");
            $table->tinyInteger('level')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer("sort_id")->default(9999);
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
        Schema::dropIfExists('categories');
    }
}
