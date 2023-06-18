<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->boolean('is_expired')->after('end_date')->default(false);
            $table->foreignId('created_by_id')->after('created_at')->nullable();
        });

        // Update all the end dates to something sensible
        // Each row fixes a different year
        DB::table('membership_purchases')
            ->whereNull('end_date')
        ->where('created_at', '<', '2017-12-31')
        ->update(['end_date'=>'2018-06-01']);
        DB::table('membership_purchases')
            ->whereNull('end_date')
        ->where('created_at', '<', '2018-12-31')
        ->update(['end_date'=>'2019-06-01']);
        DB::table('membership_purchases')
            ->whereNull('end_date')
        ->where('created_at', '<', '2019-12-31')
        ->update(['end_date'=>'2020-06-01']);
        DB::table('membership_purchases')
            ->whereNull('end_date')
        ->where('created_at', '<', '2020-12-31')
        ->update(['end_date'=>'2021-06-01']);
        DB::table('membership_purchases')
            ->whereNull('end_date')
        ->where('created_at', '<', '2021-12-31')
        ->update(['end_date'=>'2022-06-01']);
        DB::table('membership_purchases')
            ->whereNull('end_date')
        ->where('created_at', '<', '2022-12-31')
        ->update(['end_date'=>'2023-06-01']);
        DB::table('membership_purchases')
            ->whereNull('end_date')
        ->where('created_at', '<', '2023-12-31')
        ->update(['end_date'=>'2024-06-01']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->dropColumn('is_expired');
            $table->dropColumn('created_by_id');
        });
    }
};
