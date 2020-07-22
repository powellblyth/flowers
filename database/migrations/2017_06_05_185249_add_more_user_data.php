<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreUserData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrants', function (Blueprint $table) {
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('age')->nullable();
        });//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('entrants', function (Blueprint $table) {
            $table->dropColumn(['telephone', 'address', 'email', 'age']);
        });
    }
}
