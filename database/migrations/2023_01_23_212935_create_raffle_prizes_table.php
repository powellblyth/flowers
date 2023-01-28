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
        Schema::create('raffle_prizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_donor_id');
            $table->foreignId('show_id');
            $table->foreignId('contacted_by_id')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_offered')->default(false);
            $table->foreignId('winner_id')->nullable();
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
        Schema::dropIfExists('raffle_prizes');
    }
};
