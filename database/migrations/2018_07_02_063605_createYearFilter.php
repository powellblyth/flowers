<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearFilter extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('payments', function (Blueprint $table) {
            $table->integer('year')->nullable();
        }); //
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->integer('year')->nullable();
        }); //
        Schema::table('entries', function (Blueprint $table) {
            $table->integer('year')->nullable();
        }); //
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('year')->nullable();
        }); //
        
        // UPDATE payments set year=2017 where year is null
        // UPDATE membership_purchases set year=2017 where year is null
        // UPDATE entries set year=2017 where year is null
        // UPDATE categories set year=2017 where year is null
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['year']);
        });
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->dropColumn(['year']);
        });
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn(['year']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['year']);
        });
    }
}