<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('entrants', function (Blueprint $table) {
            $table->smallInteger('approx_birth_year')->nullable()->after('age');
        });
        DB::statement('UPDATE entrants SET approx_birth_year = ' .date('Y') . ' - age where age IS NOT NULL');
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entrants', function (Blueprint $table) {
            $table->dropColumn('approx_birth_year');
        });
    }
};
