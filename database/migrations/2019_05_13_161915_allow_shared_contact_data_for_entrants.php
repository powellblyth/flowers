<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowSharedContactDataForEntrants extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::table('entrants', function (Blueprint $table) {
            $table->boolean('use_user_address')->default(false);
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('entrants', function (Blueprint $table) {
            $table->dropColumn(['use_user_address']);
        });
    }
}