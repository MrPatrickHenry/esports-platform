<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('title_id');
            $table->foreign('title_id')->references('id')->on('titles');
            $table->unsignedBigInteger('thumbnails_ID');
            $table->foreign('thumbnails_ID')->references('id')->on('files');
            $table->string('link');
            $table->string('title');
            $table->string('description');
            $table->bigInteger('votes');

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
        Schema::dropIfExists('video');
    }
}
