<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToUsers extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('addresstown')->nullable();
            $table->string('postcode')->nullable();
            $table->boolean('can_retain_data')->default(false)->nullable();
            $table->dateTime('retain_data_opt_in')->nullable();
            $table->boolean('can_email')->default(false)->nullable();
            $table->dateTime('email_opt_in')->nullable();
            $table->boolean('can_phone')->default(false)->nullable();
            $table->dateTime('phone_opt_in')->nullable();
            $table->boolean('can_sms')->default(false)->nullable();
            $table->dateTime('sms_opt_in')->nullable();
        });//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'address2', 'addresstown', 'postcode', 'can_retain_data', 'retain_data_opt_in', 'can_email','email_opt_in', 'can_phone', 'phone_opt_in', 'can_sms', 'sms_opt_in' ]);
        });
    }
}
