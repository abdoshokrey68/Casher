<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicedetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicedets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('product_id')->nullable();
            $table->string('price');
            $table->string('quantity');
            $table->string('discount')->default(0); // Discount For Items
            $table->integer('invoice_id');
            $table->integer('store_id');
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
        Schema::dropIfExists('invoicedets');
    }
}