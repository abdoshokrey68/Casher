<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesettsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicesetts', function (Blueprint $table) {
            $table->id();
            $table->boolean('autotax')->nullable();
            $table->integer('tax_record')->nullable();
            $table->string('tax_card')->nullable();
            $table->string('file_no')->nullable();
            $table->integer('tax')->nullable();
            $table->string('product_rtn')->nullable();
            $table->string('message_en')->nullable();
            $table->string('message_ar')->nullable();
            $table->integer('store_id');
            $table->timestamps();

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
        Schema::dropIfExists('invoicesetts');
    }
}
