<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('scoreID');
            $table->foreign('scoreID')->references('id')->on('Scores');

            $table->string('comment',5000);
            $table->unsignedBigInteger('evidance');
            $table->foreign('evidance')->references('id')->on('files');
            $table->unsignedBigInteger('submitedBy');
            $table->foreign('submitedBy')->references('id')->on('users');

            $table->enum('decision', ['Overruled', 'Sustained','Escalated'])->nullable();

            $table->unsignedBigInteger('reviewedBy');
            $table->foreign('reviewedBy')->references('id')->on('users');



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
        Schema::dropIfExists('disputes');
    }
}
