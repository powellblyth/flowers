<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('start_date');
            $table->dateTime('ends_date');
            $table->dateTime('late_entry_deadline');
            $table->dateTime('entries_closed_deadline');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('entries', function (Blueprint $table) {
            $table->unsignedInteger('show_id')->nullable();
            $table->index(['show_id','entrant_id']);
            $table->index(['entrant_id','show_id']);
            $table->dropIndex('entrant_year');
        });

        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->unsignedInteger('show_id')->after('year')->nullable();
            $table->index(['show_id','winning_category_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('show_id')->after('year')->nullable();
            $table->index(['show_id', 'sortorder']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index(['show_id', 'entrant_id']);
            $table->unsignedInteger('show_id')->after('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shows');

        Schema::table('entries', function (Blueprint $table) {
            $table->dropIndex('entries_entrant_id_show_id_index');
            $table->dropIndex('entries_show_id_entrant_id_index');
            $table->index(['entrant_id', 'year'], 'entrant_year');
            $table->dropColumn(['show_id']);
        });

        Schema::table('cup_direct_winners', function (Blueprint $table) {
            $table->dropIndex('cup_direct_winners_show_id_winning_category_id_index');
            $table->dropColumn(['show_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_show_id_sortorder_index');
            $table->dropColumn(['show_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('payments_show_id_entrant_id_index');
            $table->dropColumn(['show_id']);
        });
    }
}
