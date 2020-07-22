<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropEntrantFromCupWinnerDirects extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->dropColumn(['entrant']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->integer('entrant')->nullable();
        }); //
    }
}
