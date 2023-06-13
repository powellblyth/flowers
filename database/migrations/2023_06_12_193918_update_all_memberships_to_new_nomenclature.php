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
        DB::table('membership_purchases')->where('type', 'family')->update(['type'=>'user']);
        DB::table('membership_purchases')->where('type', 'single')->update(['type'=>'entrant']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_nomenclature', function (Blueprint $table) {
            //
        });
    }
};
