<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWinningEntryToCupDirectWinners extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->integer('winning_entry')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->dropColumn(['winning_entry']);
        });
    }
}
