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
        DB::table('cups')->where('id', 1)->update(['section_id' => 2]);
        DB::table('cups')->where('id', 2)->update(['section_id' => 3]);
        DB::table('cups')->where('id', 3)->update(['section_id' => 4]);
        DB::table('cups')->where('id', 4)->update(['section_id' => 5]);
        DB::table('cups')->where('id', 5)->update(['section_id' => 6]);
        DB::table('cups')->where('id', 6)->update(['section_id' => 7]);
        DB::table('cups')->where('id', 7)->update(['section_id' => 9]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cups')->update(['section_id'=> null]);
    }
};
