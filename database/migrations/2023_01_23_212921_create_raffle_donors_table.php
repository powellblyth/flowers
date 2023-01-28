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
        Schema::create('raffle_donors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->text('description');
            $table->boolean('should_contact_again')->default(true);
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
        Schema::dropIfExists('raffle_donors');
    }
};
