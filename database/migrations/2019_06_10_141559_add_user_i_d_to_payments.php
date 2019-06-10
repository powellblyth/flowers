<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIDToPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `payments` MODIFY `entrant_id` INT(11) NULL');
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
        });
        DB::statement('UPDATE payments SET user_id = (select user_id from entrants where entrants.id=payments.entrant_id) where user_id IS NULL');
        Schema::table('payments', function (Blueprint $table) {
            $table->index(['user_id', 'year', 'entrant_id', ], 'entrant_user_year');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('entrant_user_year');
        });


    }
}
