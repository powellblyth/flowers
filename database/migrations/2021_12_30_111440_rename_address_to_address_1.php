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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('address', 'address_1');
            $table->renameColumn('address2', 'address_2');
            $table->renameColumn('addresstown', 'address_town');
            $table->renameColumn('firstname', 'first_name');
            $table->renameColumn('lastname', 'last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('address_1', 'address');
            $table->renameColumn('address_2', 'address2');
            $table->renameColumn('address_town', 'addresstown');
            $table->renameColumn('first_name', 'firstname');
            $table->renameColumn('last_name', 'lastname');
        });
    }
};
