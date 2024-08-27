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
        Schema::create('merge_user_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id');
            $table->foreignId('to_user_id');
            $table->foreignId('merged_by_user_id')->nullable();
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
        Schema::dropIfExists('merge_user_logs');
    }
};
