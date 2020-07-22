<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptOutDateToEntrant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('entrants', function (Blueprint $table) {
            $table->boolean('can_post')->default(false)->nullable();
            $table->dateTime('post_opt_in')->nullable();
            $table->dateTime('post_opt_out')->nullable();
            $table->dateTime('sms_opt_out')->nullable();
            $table->dateTime('retain_data_opt_out')->nullable();
            $table->dateTime('phone_opt_out')->nullable();
            $table->dateTime('email_opt_out')->nullable();
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
            $table->dropColumn(['can_post', 'post_opt_in', 'post_opt_out', 'sms_opt_out', 'retain_data_opt_out', 'phone_opt_out', 'email_opt_out']);
        });
    }
}

