<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktivitas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('villa_id')->unsigned();
            $table->foreign('villa_id')->references('id')->on('villas')->onDelete('cascade');
            $table->string('imageUrl');
            $table->string('name');
            $table->string('type');
            $table->string('startTimes');
            $table->string('rating');
            $table->string('price');
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
        Schema::dropIfExists('aktivitas');
    }
}
