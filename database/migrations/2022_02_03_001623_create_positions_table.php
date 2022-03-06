<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->integer('member_id');
            $table->integer('position')->default(0); // [0] => Manager || [1] => Casher || [2] => Restaurant || [3] => Supervisor

            $table->boolean('invoice_show')->default(0);
            $table->boolean('invoice_add')->default(0);
            $table->boolean('invoice_edit')->default(0);
            $table->boolean('invoice_delete')->default(0);

            $table->boolean('section_show')->default(0);
            $table->boolean('section_add')->default(0);
            $table->boolean('section_edit')->default(0);
            $table->boolean('section_delete')->default(0);

            $table->boolean('member_show')->default(0);
            $table->boolean('member_add')->default(0);
            $table->boolean('member_edit')->default(0);
            $table->boolean('member_delete')->default(0);

            $table->boolean('product_show')->default(0);
            $table->boolean('product_add')->default(0);
            $table->boolean('product_edit')->default(0);
            $table->boolean('product_delete')->default(0);

            $table->boolean('table_show')->default(0);
            $table->boolean('table_add')->default(0);
            $table->boolean('table_edit')->default(0);
            $table->boolean('table_delete')->default(0);

            $table->boolean('history_show')->default(0);
            $table->boolean('history_delete')->default(0);

            $table->boolean('menu_edit')->default(0);

            $table->boolean('store_edit')->default(0);

            $table->boolean('box_add')->default(0);
            // $table->boolean('box_edit')->default(0);

            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
