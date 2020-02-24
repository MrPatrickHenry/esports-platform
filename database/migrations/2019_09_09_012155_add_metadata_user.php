<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetadataUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)
            ->unique()
                ->after('password')
                ->nullable()
            ;
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Fsemale','X'])->nullable();

        });
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')
                ->after('gender')
                ->nullable()
            ;
        });
         Schema::table('users', function (Blueprint $table) {
            $table->string('Discord', 30)
                ->after('gender')
                ->unique()
                ->nullable()
            ;
        });
          Schema::table('users', function (Blueprint $table) {
            $table->string('Instagram', 30)
                ->after('gender')
                ->unique()
                ->nullable()
            ;
        });
           Schema::table('users', function (Blueprint $table) {
            $table->string('Telegram', 30)
                ->after('gender')
                ->unique()
                ->nullable()
            ;
        });
            Schema::table('users', function (Blueprint $table) {
            $table->string('Twitter', 30)
                ->after('gender')
                ->unique()
                ->nullable()
            ;
        });
             Schema::table('users', function (Blueprint $table) {
            $table->string('Snapchat', 30)
                ->after('gender')
                ->unique()
                ->nullable()
            ;
        });
              Schema::table('users', function (Blueprint $table) {
            $table->string('YouTube', 30)
                ->after('gender')
                ->unique()
                ->nullable()
            ;
        });
               Schema::table('users', function (Blueprint $table) {
            $table->string('Address1', 70)
                ->after('gender')
                ->nullable()
            ;
        });
                Schema::table('users', function (Blueprint $table) {
            $table->string('Address2', 70)
                ->after('Address1')
                ->nullable()
            ;
        });
                 Schema::table('users', function (Blueprint $table) {
            $table->string('City' , 50)
                ->after('Address2')
                ->nullable()
            ;
        });
                  Schema::table('users', function (Blueprint $table) {
            $table->string('Zip_Post' , 20)
                ->after('City')
                ->nullable()
            ;
        });
                   Schema::table('users', function (Blueprint $table) {
            $table->string('Country' , 20)
                ->after('City')
                ->nullable()
            ;
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
