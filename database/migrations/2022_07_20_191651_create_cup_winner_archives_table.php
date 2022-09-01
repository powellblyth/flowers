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
        Schema::create('cup_winner_archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cup_id');
            $table->foreignId('show_id');
            $table->foreignId('cup_winner_entrant_id')->nullable();
            $table->unsignedMediumInteger('cup_winner_points')->nullable();
            $table->foreignId('entry_id')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->index(['cup_id','show_id']);
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
        Schema::dropIfExists('cup_winner_archives');
    }
};
