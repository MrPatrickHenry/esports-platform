<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
/**
 * Run the migrations.
 *
 * @return void
 */
public function up()
{
    Schema::create('payments', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedBigInteger('payer_id')->nullable();
        $table->foreign('payer_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        $table->unsignedBigInteger('subscription_id')->nullable();
        $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null')->onUpdate('cascade')    ;
        $table->string('stripe_charge_id')->collation('utf8mb4_bin')->unique();
        $table->string('stripe_transaction_id')->collation('utf8mb4_bin')->unique();
        $table->integer('amount');
        $table->string('currency', 3);
        $table->string('status', 20)->default('pending');
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
    Schema::table('payments', function (Blueprint $table) {
        $table->dropForeign(['payer_id']);
    });

    Schema::drop('payments');
}
}
