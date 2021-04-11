<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrant_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrant_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedInteger('show_id');
            $table->timestamps();
            $table->index(['entrant_id', 'team_id', 'show_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrant_team');
    }
}
