<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoreEntrantData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrants', function (Blueprint $table) {
    $table->string('address2')->nullable();
    $table->string('addresstown')->nullable();
    $table->string('postcode')->nullable();
});//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entrants', function (Blueprint $table) {
         $table->dropColumn(['address2', 'addresstown', 'postcode']);
        });
    }
}
