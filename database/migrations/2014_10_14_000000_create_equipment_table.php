<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('version')->nullable();
            $table->boolean('available')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('video');
            $table->foreign('video')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('pic_1');
            $table->foreign('pic_1')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('pic_2');
            $table->foreign('pic_2')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('icon');
            $table->foreign('icon')->references('id')->on('files')->onDelete('cascade');

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
        Schema::dropIfExists('equipment');
    }
}
