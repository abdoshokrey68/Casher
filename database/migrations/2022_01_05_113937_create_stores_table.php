<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('cover')->nullable();
            $table->string('description')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('fb')->nullable();
            $table->string('email')->nullable();
            $table->string('audience')->default(0);
            $table->string('currency')->nullable();
            $table->integer('discount')->default(0);
            $table->integer('manager_id');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
