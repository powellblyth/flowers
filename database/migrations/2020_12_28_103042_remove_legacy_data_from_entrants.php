<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLegacyDataFromEntrants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrants', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'address2',
                'addresstown',
                'email',
                'postcode',
                'telephone',
                'can_email',
                'email_opt_in',
                'email_opt_out',
                'can_sms',
                'sms_opt_in',
                'sms_opt_out',
                'can_post',
                'post_opt_in',
                'post_opt_out',
                'can_phone',
                'phone_opt_in',
                'phone_opt_out',
                'use_user_address',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entrants', function (Blueprint $table) {
            $table->string('address');
            $table->string('address2');
            $table->string('email');
            $table->string('addresstown');
            $table->string('postcode');
            $table->string('telephone');
            $table->string('can_email');
            $table->string('email_opt_in');
            $table->string('email_opt_out');
            $table->string('can_post');
            $table->string('post_opt_in');
            $table->string('post_opt_out');
            $table->string('can_sms');
            $table->string('sms_opt_in');
            $table->string('sms_opt_out');
            $table->string('can_phone');
            $table->string('phone_opt_in');
            $table->string('phone_opt_out');
            $table->string('use_user_address');
        });
    }
}
