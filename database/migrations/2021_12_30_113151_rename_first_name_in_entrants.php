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
        Schema::table('entrants', function (Blueprint $table) {
            $table->renameColumn('firstname', 'first_name');
            $table->renameColumn('familyname', 'family_name');
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
            $table->renameColumn('first_name', 'firstname');
            $table->renameColumn('family_name', 'familyname');
        });
    }
};
