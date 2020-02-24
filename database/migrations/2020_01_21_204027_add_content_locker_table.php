<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContentLockerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contentLocker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('video');
            $table->foreign('video')->references('id')->on('files');
            $table->unsignedBigInteger('thumbnail');
            $table->foreign('thumbnail')->references('id')->on('files');
            $table->string('title');
            $table->text('description');
            $table->text('tags');
            $table->unsignedBigInteger('game');
            $table->foreign('game')->references('id')->on('tiles');
            $table->integer('like');
            $table->integer('dislike');
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
        Schema::dropIfExists('contentLocker');
    }
}
