<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSectionFromCategories extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['section']);
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('categories', function (Blueprint $table) {
            $table->string('section')->nullable();
        });
    }
}