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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('entrant_user_year');
            $table->index([ 'user_id','show_id', 'entrant_id'], 'entrant_user_show');
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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('entrant_user_show');
            $table->index(['user_id', 'year','entrant_id'], 'entrant_user_year');
        });
    }
};
