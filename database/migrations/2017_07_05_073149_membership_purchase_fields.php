<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MembershipPurchaseFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membership_purchases', function (Blueprint $table) {
    $table->integer('entrant');
    $table->integer('amount');
    $table->string('type');

        });//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership_purchases', function (Blueprint $table) {
         $table->dropColumn(['entrant','amount','type', 'created']);
        });
    }
}
