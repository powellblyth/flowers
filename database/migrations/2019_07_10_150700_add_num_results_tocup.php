<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumResultsTocup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('cups', function (Blueprint $table) {
            $table->unsignedInteger('num_display_results')->default(2)->nullable();
        });
        DB::statement('UPDATE cups set num_display_results=4 where id=13 LIMIT 1');
        DB::statement('UPDATE cups set num_display_results=3 where id IN(11,12) LIMIT 2');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cups', function (Blueprint $table) {
            $table->dropColumn(['num_display_results']);
        });
    }
}
