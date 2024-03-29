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
        DB::raw('TRUNCATE TABLE teams');
        \DB::table('teams')->insert(array(
            array(
                'id' => 1,
                'name' => 'The Russell School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 2,
                'name' => 'Darell Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 3,
                'name' => 'Deer Park Primary',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 4,
                'name' => 'Holy Trinity CE Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 5,
                'name' => 'Kew Riverside Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 6,
                'name' => 'Marshgate Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 7,
                'name' => 'Meadlands Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 8,
                'name' => 'The Queen\'s CE Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 9,
                'name' => 'St Elizabeth\'s Catholic Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 10,
                'name' => 'St Richard\'s CE Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 11,
                'name' => 'The Vineyard Primary School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 12,
                'name' => 'Windham Nursery School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 13,
                'name' => 'Trafalgar Infant School',
                'status' => 'active',
                'min_age' => 3,
                'max_age' => 11,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 14,
                'name' => 'Grey Court School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 15,
                'name' => 'Christ\'s School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 16,
                'name' => 'Hampton High',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 17,
                'name' => 'Orleans Park School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 18,
                'name' => 'Richmond Park Academy',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 19,
                'name' => 'St Richard Reynolds Catholic High School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 20,
                'name' => 'Teddington School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 21,
                'name' => 'The Richmond upon Thames School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 22,
                'name' => 'Turing House School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 23,
                'name' => 'Twickenham School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 24,
                'name' => 'Waldegrave School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 25,
                'name' => 'Tiffin Girl\'s School',
                'status' => 'active',
                'min_age' => 11,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 26,
                'name' => 'Sudbrook School',
                'status' => 'active',
                'min_age' => 2,
                'max_age' => 6,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 27,
                'name' => 'Strathmore School',
                'status' => 'active',
                'min_age' => 5,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 28,
                'name' => 'Kish Kindergarten',
                'status' => 'active',
                'min_age' => 2,
                'max_age' => 6,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
            array(
                'id' => 29,
                'name' => 'The German School',
                'status' => 'active',
                'min_age' => 5,
                'max_age' => 18,
                'created_at' => '2020-04-23 09:04:26',
                'updated_at' => '2020-04-23 09:04:26',
            ),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
