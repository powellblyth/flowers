<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('status')->nullable();
            $table->tinyInteger('min_age')->unsigned()->nullable();
            $table->tinyInteger('max_age')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('entrant_team_year', function(Blueprint $table){
            $table->id();

        });

        Schema::table('entrants', function (Blueprint $table) {
            $table->unsignedInteger('team_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
        Schema::table('entrants', function (Blueprint $table) {
            $table->dropColumn(['team_id']);
        });
    }
}
