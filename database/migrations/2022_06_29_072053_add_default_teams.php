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
        \Illuminate\Support\Facades\DB::raw('TRUNCATE TABLE teams');
\Illuminate\Support\Facades\DB::raw("INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (1, 'The Russell School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (2, 'Darell Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (3, 'Deer Park Primary', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (4, 'Holy Trinity CE Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (5, 'Kew Riverside Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (6, 'Marshgate Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (7, 'Meadlands Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (8, 'The Queen''s CE Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (9, 'St Elizabeth''s Catholic Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (10, 'St Richard''s CE Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (11, 'The Vineyard Primary School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (12, 'Windham Nursery School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (13, 'Trafalgar Infant School', 'active', 3, 11, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (14, 'Grey Court School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (15, 'Christ''s School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (16, 'Hampton High', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (17, 'Orleans Park School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (18, 'Richmond Park Academy', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (19, 'St Richard Reynolds Catholic High School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (20, 'Teddington School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (21, 'The Richmond upon Thames School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (22, 'Turing House School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (23, 'Twickenham School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (24, 'Waldegrave School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (25, 'Tiffin Girl''s School', 'active', 11, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (26, 'Sudbrook School', 'active', 2, 6, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (27, 'Strathmore School', 'active', 5, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (28, 'Kish Kindergarten', 'active', 2, 6, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
INSERT INTO teams (id, name, status, min_age, max_age, created_at, updated_at) VALUES (29, 'The German School', 'active', 5, 18, '2020-04-23 09:04:26.0', '2020-04-23 09:04:26.0');
");
        //
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
