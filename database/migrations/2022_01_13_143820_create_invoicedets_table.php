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
            $table->decimal('price', $precision = 19, $scale = 2)->default(0.00);
            $table->integer('quantity');
            // $table->string('discount')->default(0); // Discount For Items
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('store_id');
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
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
