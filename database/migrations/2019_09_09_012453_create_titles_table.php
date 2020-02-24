<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('developer');
            $table->foreign('developer')
                ->references('id')
                ->on('developers')
                ->onUpdate('cascade');
            $table->string('name',100);
            $table->text('desc',255);
            $table->string('availability',100);
            $table->string('rules',255);
            $table->string('links',100);
            $table->string('pic',100);
            $table->string('video',100);
            $table->string('icon',100);
            $table->boolean('active');
            $table->softDeletes();
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
        Schema::dropIfExists('titles');
    }
}
