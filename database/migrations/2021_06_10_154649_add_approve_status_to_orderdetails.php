<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApproveStatusToOrderdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderdetails', function (Blueprint $table) {
            $table->tinyInteger('approve_status')->default(0)->comment("1 = accepted, 0 = Rejected");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderdetails', function (Blueprint $table) {
            $table->dropColumn('approve_status');
        });
    }
}
