<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_bank_details', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
//            $table->integer('type_of_business')->nullable();
//            $table->integer('nature_of_business')->nullable();
//            $table->string('licence_no')->nullable();
//            $table->string('tin_tax_id')->nullable();
//            $table->string('vat_no')->nullable();
//            $table->string('incorporation_no')->nullable();

//            $table->integer('type_product')->nullable();

            $table->tinyInteger('status')->default(1)->comment("1=active, 2=inactive");
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
        Schema::dropIfExists('vendor_bank_details');
    }
}
