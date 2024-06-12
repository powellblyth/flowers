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
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('judge_role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->foreignId('judge_role_id')->nullable()->after('is_junior');
        });
        DB::table('sections')->query("UPDATE flowers.sections SET judge_role_id = 9 WHERE id = 83;
UPDATE flowers.sections SET judge_role_id = 8 WHERE id = 77;
UPDATE flowers.sections SET judge_role_id = 8 WHERE id = 84;
UPDATE flowers.sections SET judge_role_id = 7 WHERE id = 81;
UPDATE flowers.sections SET judge_role_id = 7 WHERE id = 85;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 5;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 15;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 25;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 35;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 45;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 55;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 65;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 75;
UPDATE flowers.sections SET judge_role_id = 5 WHERE id = 79;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 6;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 16;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 26;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 36;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 46;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 56;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 66;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 76;
UPDATE flowers.sections SET judge_role_id = 4 WHERE id = 80;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 3;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 13;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 23;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 33;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 43;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 53;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 63;
UPDATE flowers.sections SET judge_role_id = 3 WHERE id = 73;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 4;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 14;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 24;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 34;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 44;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 54;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 64;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 74;
UPDATE flowers.sections SET judge_role_id = 2 WHERE id = 82;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 2;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 12;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 22;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 32;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 42;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 52;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 62;
UPDATE flowers.sections SET judge_role_id = 1 WHERE id = 72;
");
    }
};
