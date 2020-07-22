<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CupWinningCriteria extends Migration {

    public function up() {
        Schema::table('cups', function (Blueprint $table) {
            $table->integer('winning_criteria')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cups', function (Blueprint $table) {
            $table->dropColumn(['winning_criteria']);
        });
    }
}
