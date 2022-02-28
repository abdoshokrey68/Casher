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
            $table->string('invoice')->default(0);
            $table->string('section')->default(0);
            $table->string('member')->default(0);
            $table->string('product')->default(0);
            $table->string('table')->default(0);
            $table->string('box')->default(0);
            $table->string('store')->default(0);
            $table->string('history')->default(0);
            $table->string('menu')->default(0);
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
        Schema::dropIfExists('positions');
    }
}
