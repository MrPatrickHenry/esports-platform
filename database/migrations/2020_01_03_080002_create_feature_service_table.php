<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featureService', function (Blueprint $table) {
            $table->bigIncrements('id');
            //navigation view
            $table->string('icon');
            $table->string('english_Label');
            $table->string('uri');
            //Filtering on the above and or below to see if have access based on true or false
            $table->string('user_IDs');
            $table->string('country');
            $table->enum('player_Type', ['Player','Team Manager','All']);
            $table->enum('user_Type', ['Developers','VALAdmin','Players','All','Arcade Owner']);
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
        Schema::dropIfExists('featureService');
    }
}
