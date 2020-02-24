<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('cost', 8,2);
            $table->integer('currency');
            $table->string('desc',255);
            $table->string('link',2000);
            $table->unsignedBigInteger('pic');
            $table->foreign('pic')->references('id')->on('files')->onUpdates('cascade');
            $table->unsignedBigInteger('icon');

            $table->foreign('icon')
            ->references('id')
            ->on('files')
            ->onUpdates('cascade');
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
        Schema::dropIfExists('services');
    }
}
