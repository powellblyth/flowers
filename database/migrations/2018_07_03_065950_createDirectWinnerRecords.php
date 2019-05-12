<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectWinnerRecords extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cup_direct_winners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cup');
            $table->integer('entrant');
            $table->integer('year')->default('2017');
            $table->integer('winning_category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cup_direct_winners');
    }
}
