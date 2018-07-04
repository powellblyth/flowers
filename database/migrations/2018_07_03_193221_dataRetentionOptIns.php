<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataRetentionOptIns extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('entrants', function (Blueprint $table) {
            $table->boolean('can_retain_data')->default(false)->nullable();
            $table->dateTime('retain_data_opt_in')->nullable();
            $table->boolean('can_email')->default(false)->nullable();
            $table->dateTime('email_opt_in')->nullable();
            $table->boolean('can_phone')->default(false)->nullable();
            $table->dateTime('phone_opt_in')->nullable();
            $table->boolean('can_sms')->default(false)->nullable();
            $table->dateTime('sms_opt_in')->nullable();
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('entrants', function (Blueprint $table) {
            $table->dropColumn(['can_retain_data']);
            $table->dropColumn(['retain_data_opt_in']);
            $table->dropColumn(['can_email']);
            $table->dropColumn(['email_opt_in']);
            $table->dropColumn(['can_sms']);
            $table->dropColumn(['sms_opt_in']);
        });
    }
}
