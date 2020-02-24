<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLicensingToArcadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arcades', function (Blueprint $table) {
        // $table->string('licensing',3)->default('5')->nullable();
        $table->enum('licensing', ['PLVR', 'Springboard','Ctrl V','Synthesis','Steam Cafe','Viveport','Neurogaming','MK2','direct deals','other'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arcades', function (Blueprint $table) {
            //
        });
    }
}
