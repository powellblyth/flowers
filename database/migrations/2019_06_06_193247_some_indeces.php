<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SomeIndeces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `users` CHANGE `email` `email` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL');
        DB::statement('ALTER TABLE `users` CHANGE `password` `password` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL');
        Schema::table('users', function (Blueprint $table) {
            $table->index(['lastname', 'firstname'], 'user_name_search');
            $table->index(['email', 'password'], 'user_login');
        });
        Schema::table('entrants', function (Blueprint $table) {
            $table->index(['user_id'], 'user_id');
        });
        Schema::table('entries', function (Blueprint $table) {
            $table->index(['entrant_id', 'year'], 'entrant_year');
            $table->index(['category_id', 'year'], 'entry_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('user_name_search');
            $table->dropIndex('user_login');
        });
        Schema::table('entrants', function (Blueprint $table) {
            $table->dropIndex('user_id');
        });
        Schema::table('entries', function (Blueprint $table) {
            $table->dropIndex('entrant_year');
            $table->dropIndex('entry_category');
        });
        //
    }
}
