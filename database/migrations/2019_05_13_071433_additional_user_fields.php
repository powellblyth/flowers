<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdditionalUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname');
            $table->string('lastname');
            $table->string('auth_token');
            $table->string('password_reset_token');
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->dropColumn(['name']);
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['auth_token', 'password_reset_token', 'firstname','lastname', 'status']);
            $table->string('name');
        });
    }
}
