<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->integer('create_id');
            $table->integer('store_id');
            $table->integer('discount')->default(0); // Discount For All Invoice on For Store
            $table->integer('total')->nullable();
            $table->integer('paid')->nullable();
            $table->integer('table_id')->nullable();
            $table->integer('status')->default(0); // if this is finished => [1];
            $table->softDeletes();
            $table->timestamps();

            // $table->foreignId('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
