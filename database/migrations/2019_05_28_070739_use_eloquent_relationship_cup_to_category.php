<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UseEloquentRelationshipCupToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('cup_to_categories', 'category_cup');
        Schema::table('category_cup', function (Blueprint $table) {
            $table->renameColumn('category', 'category_id');
            $table->renameColumn('cup', 'cup_id');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_cup', function (Blueprint $table) {
            $table->renameColumn('cup_id', 'cup');
            $table->renameColumn('category_id', 'category');
        });
        Schema::rename('category_cup', 'cup_to_categories');
    }
}
