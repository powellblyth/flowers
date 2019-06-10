<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RejigMembership extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
        });
        Schema::dropIfExists('memberships');
        DB::statement('UPDATE membership_purchases SET user_id = (select user_id from entrants where entrants.id=membership_purchases.entrant_id) where user_id IS NULL');
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->index(['user_id', 'year', 'entrant_id',], 'entrant_user_year');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->dropIndex('entrant_user_year');
        });


    }
}
