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
        Schema::create('merge_entrant_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_entrant_id');
            $table->foreignId('to_entrant_id');
            $table->foreignId('from_user_id');
            $table->foreignId('to_user_id');
            $table->string('merge_type');
            $table->jsonb('metadata');
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
        Schema::dropIfExists('merge_entrant_logs');
    }
};
