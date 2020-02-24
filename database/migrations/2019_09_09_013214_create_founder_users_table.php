<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFounderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('founder_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('userID');

            $table->foreign('userID')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');   
                        $table->unsignedBigInteger('assigned');
   
               $table->foreign('assigned')
                ->references('id')
                ->on('founder_types')
                ->onDelete('cascade');
            $table->text('notes');
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
        Schema::dropIfExists('founder_users');
    }
}
