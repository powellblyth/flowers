<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cups', function (Blueprint $table) {
            $table->string('winning_basis')->default('total_points');
        });
        DB::table('cups')
            ->whereIn('id', [14, 15, 16, 17, 18, 24, 25, 26, 27, 28, 29])
            ->update(['winning_basis' => \App\Models\Cup::WINNING_BASIS_JUDGES_CHOICE]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cups', function (Blueprint $table) {
            $table->dropColumn('winning_basis');
        });
    }
};
