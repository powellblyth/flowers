<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWinningCategoryToCupDirectWinners extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->integer('winning_category')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->dropColumn(['winning_category']);
        });
    }
}
