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
        Schema::create('judge_roles', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });

        // Some tasty defaults
        DB::table('judge_roles')->insert(['label' => 'Flowers']);
        DB::table('judge_roles')->insert(['label' => 'Vegetables']);
        DB::table('judge_roles')->insert(['label' => 'Fruit']);
        DB::table('judge_roles')->insert(['label' => 'Cookery']);
        DB::table('judge_roles')->insert(['label' => 'Floral Art']);
        DB::table('judge_roles')->insert(['label' => 'Cooking']);
        DB::table('judge_roles')->insert(['label' => 'Photography']);
        DB::table('judge_roles')->insert(['label' => 'Arts and Crafts']);

        Schema::create(
            'judge_show',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('judge_id');
                // In case one judge performs multiple judging for a show
                $table->foreignId('judge_role_id');
                $table->foreignId('show_id');
                $table->timestamps();
            }
        );
        Schema::create(
            'category_judge_role',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id');
                $table->foreignId('judge_role_id');
                $table->timestamps();
            }
        );
        // some cups are awarded by judget type
        Schema::create('cup_judge_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cup_id');
            $table->foreignId('judge_role_id');
            $table->timestamps();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreignId('judge_role_id')->nullable();
        });


        DB::table('sections')->where('id', 2)->update(['judge_role_id' => 1]);
        DB::table('sections')->where('id', 3)->update(['judge_role_id' => 3]);
        DB::table('sections')->where('id', 4)->update(['judge_role_id' => 2]);
        DB::table('sections')->where('id', 5)->update(['judge_role_id' => 5]);
        DB::table('sections')->where('id', 6)->update(['judge_role_id' => 6]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('judge_role_section');
        Schema::dropIfExists('category_judge_role');
        Schema::dropIfExists('judge_roles');
        Schema::dropIfExists('judge_judge_role');
        Schema::dropIfExists('judge_show');
        Schema::dropIfExists('cup_judge_role');

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('judge_role_id');
        });
    }
};
