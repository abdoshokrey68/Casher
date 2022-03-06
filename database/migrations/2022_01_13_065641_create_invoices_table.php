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
            $table->integer('member_id');
            $table->integer('store_id');
            $table->integer('discount')->default(0); // Discount For All Invoice on For Store
            $table->decimal('total', $precision = 19, $scale = 2)->default(0.00);
            $table->decimal('f_discount', $precision = 19, $scale = 2)->default(0.00);
            $table->decimal('paid', $precision = 19, $scale = 2)->nullable();
            $table->integer('table_id')->nullable();
            $table->integer('status')->default(0); // if this is finished => [1];
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
