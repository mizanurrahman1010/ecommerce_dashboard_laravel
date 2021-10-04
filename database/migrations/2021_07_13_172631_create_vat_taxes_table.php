<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVatTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default(0);
            $table->integer('value');
            $table->integer('type')->default(1)->comment("1=vat, 2=tax");
            $table->integer('status')->default(1)->comment("1=active, 2=inactive");
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
        Schema::dropIfExists('vat_taxes');
    }
}
