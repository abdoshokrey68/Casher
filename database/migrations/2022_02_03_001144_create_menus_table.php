<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('qrcode_name')->nullable();
            $table->integer('design_no')->nullable();
            $table->string('background_co')->default('#052531');
            $table->string('text_co')->default('#000000');
            $table->string('heading_co')->default('#052531');
            $table->string('des_co')->default('#787878');
            $table->string('icon_co')->default('#000000');
            $table->string('price_co')->default('#000000');
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
        Schema::dropIfExists('menus');
    }
}
