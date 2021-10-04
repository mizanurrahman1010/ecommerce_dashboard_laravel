<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->string('trade_license_doc')->nullable();
            $table->string('vat_certification_no')->nullable();
            $table->string('vat_certification_doc')->nullable();
            $table->string('tin_certification_no')->nullable();
            $table->string('tin_certification_doc')->nullable();
            $table->string('bsti_certification_no')->nullable();
            $table->string('bsti_certification_doc')->nullable();

            $table->string('licence_no')->nullable();
            $table->string('tin_tax_id')->nullable();
            $table->string('vat_no')->nullable();
            $table->string('incorporation_no')->nullable();


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
        Schema::dropIfExists('vendor_documents');
    }
}
