<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('cups', function (Blueprint $table) {
            $table->string('image')->nullable()->after('prize_description');
        });
        DB::table('cups')->where('id', '=', 25)->update(['image' => 'anne_millard_cup.jpg']);
        DB::table('cups')->where('id', '=', 14)->update(['image' => 'anthony_rampton_memorial_prize.jpg']);
        DB::table('cups')->where('id', '=', 2)->update(['image' => 'clifford_bragg_cup.jpg']);
        DB::table('cups')->where('id', '=', 29)->update(['image' => 'col_bromhead_memorial_cup.jpg']);
        DB::table('cups')->where('id', '=', 15)->update(['image' => 'cowen_cup.jpg']);
        DB::table('cups')->where('id', '=', 1)->update(['image' => 'cowen_memorial_challenge_bowl.jpg']);
        DB::table('cups')->where('id', '=', 7)->update(['image' => 'edmonds_cup.jpg']);
        DB::table('cups')->where('id', '=', 18)->update(['image' => 'harry_thorne_memorial_cup.jpg']);
        DB::table('cups')->where('id', '=', 4)->update(['image' => 'james_clarke_memorial_cup.jpg']);
        DB::table('cups')->where('id', '=', 26)->update(['image' => 'john_grapes_memorial_trophy.jpg']);
        DB::table('cups')->where('id', '=', 9)->update(['image' => 'kathleen_and_harold_sharp_trophy.jpg']);
        DB::table('cups')->where('id', '=', 24)->update(['image' => 'lambert_memorial_bowl.jpg']);
        DB::table('cups')->where('id', '=', 10)->update(['image' => 'mary_turner_cup.jpg']);
        DB::table('cups')->where('id', '=', 17)->update(['image' => 'north_trophy.jpg']);
        DB::table('cups')->where('id', '=', 8)->update(['image' => 'pamela_griffiths_memorial_cup.jpg']);
        DB::table('cups')->where('id', '=', 3)->update(['image' => 'petersham_perpetual_challenge_cup.jpg']);
        DB::table('cups')->where('id', '=', 5)->update(['image' => 'phillip_carr_challenge_cup.jpg']);
        DB::table('cups')->where('id', '=', 6)->update(['image' => 'Violet_lincoln_memorial_salver.jpg']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cups', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
