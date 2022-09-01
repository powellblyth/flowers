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
        Schema::create('cup_winner_archive_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cup_winner_archive_id');
            $table->foreignId('entrant_id')->index();
            $table->unsignedMediumInteger('points')->nullable();
            $table->unsignedMediumInteger('entry_id')->nullable();
            $table->unsignedSmallInteger('sort_order');
            $table->index('cup_winner_archive_id', 'sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cup_winner_archive_winners');
    }
};
