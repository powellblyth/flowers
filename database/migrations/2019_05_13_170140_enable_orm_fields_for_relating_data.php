<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnableOrmFieldsForRelatingData extends Migration {
    /**
     * Note this constructor works around an issue with enums and DBAL
     * https://stackoverflow.com/questions/33140860/laravel-5-1-unknown-database-type-enum-requested
     */
    public function __construct() {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('entries', function (Blueprint $table) {
            $table->renameColumn('entrant', 'entrant_id');
            $table->renameColumn('category', 'category_id');
        }); //
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('entrant', 'entrant_id');
        }); //
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->renameColumn('entrant', 'entrant_id');
            $table->renameColumn('cup', 'cup_id');
            $table->renameColumn('winning_entry', 'winning_entry_id');
            $table->renameColumn('winning_category', 'winning_category_id');
        }); //
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->renameColumn('entrant', 'entrant_id');
        }); //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('entries', function (Blueprint $table) {
            $table->renameColumn('entrant_id', 'entrant');
            $table->renameColumn('category_id', 'category');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('entrant_id', 'entrant');
        });
        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->renameColumn('entrant_id', 'entrant');
            $table->renameColumn('cup_id', 'cup');
            $table->renameColumn('winning_category_id', 'winning_category');
            $table->renameColumn('winning_entry_id', 'winning_entry');
        });
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->renameColumn('entrant_id', 'entrant');
        }); //
    }
}