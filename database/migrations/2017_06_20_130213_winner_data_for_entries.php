<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WinnerDataForEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
    $table->string('winningplace')->nullable();
});//
        Schema::table('categories', function (Blueprint $table) {
    $table->integer('first_prize')->nullable();
    $table->integer('second_prize')->nullable();
    $table->integer('third_prize')->nullable();
});//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
         $table->dropColumn(['winningplace']);
        });
        Schema::table('categories', function (Blueprint $table) {
         $table->dropColumn(['first_prize', 'second_prize', 'third_prize']);
        });
    }
}
