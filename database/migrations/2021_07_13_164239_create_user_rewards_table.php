<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer("point")->default(0);
            $table->integer("max_order_per_user")->default(1);
            $table->integer("max_order_users")->default(1);
            $table->integer("point_up_to")->default(0);
            $table->integer("placed_order")->default(0);
            $table->text("image")->nullable();
            $table->bigInteger("conv_start_date");
            $table->bigInteger("conv_end_date");
            $table->text("description")->nullable();
            $table->text("term_conditions")->nullable();
            $table->tinyInteger("status")->default(1)->comment("1=active,2=inactive");
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
        Schema::dropIfExists('user_rewards');
    }
}
