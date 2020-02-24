<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArcadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arcades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('adminID');
            $table->foreign('adminID')->references('id')->on('users');
            $table->string('name',100);
            $table->text('desc',2000);
            $table->string('email',100);
            $table->string('website',100);
            $table->string('youtubeVideo',500);
            $table->string('youtubeChannel',500);
            $table->string('discord',100);
            $table->string('instagram',100);
            $table->string('telegram',100);
            $table->string('twitter',100);
            $table->string('snapchat',100);
            $table->string('twitch',100);
            $table->string('address1',100);
            $table->string('address2',100);
            $table->string('city',100);
            $table->string('state',100);
            $table->string('zip_postal',100);
            $table->string('lat',50);
            $table->string('long',50);
            $table->string('phone',30);
            $table->string('notes',500);
            $table->unsignedBigInteger('logo');
            $table->foreign('logo')->references('id')->on('files')->onUpdate('cascade');
            $table->unsignedBigInteger('pic1');
            $table->foreign('pic1')->references('id')->on('files')->onUpdate('cascade');
            $table->unsignedBigInteger('pic2');
            $table->foreign('pic2')->references('id')->on('files')->onUpdate('cascade');
            $table->unsignedBigInteger('pic3');
            $table->foreign('pic3')->references('id')->on('files')->onUpdate('cascade');
            $table->unsignedBigInteger('pic4');
            $table->foreign('pic4')->references('id')->on('files')->onUpdate('cascade');
            // $table->integer('Openhours',255);
            $table->unsignedBigInteger('icon');
            $table->foreign('icon')->references('id')->on('files')->onUpdate('cascade');
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
        Schema::dropIfExists('arcades');
    }
}
