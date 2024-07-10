<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropEntrantFromCupWinnerDirects extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->dropColumn(['entrant']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->integer('entrant')->nullable();
        }); //
    }
}
