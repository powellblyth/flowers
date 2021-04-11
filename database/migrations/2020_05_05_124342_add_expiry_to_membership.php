<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpiryToMembership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->index(['start_date','end_date', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
            $table->index('membership_purchases_start_date_end_date_show_id_index');
        });
    }
}
