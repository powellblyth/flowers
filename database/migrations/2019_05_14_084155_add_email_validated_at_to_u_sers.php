<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailValidatedAtToUSers extends Migration
{
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('email_verified_at')->nullable();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email_verified_at']);
        });
    }
}
