<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->text('notes')->nullable();
            $table->text('judges')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('section_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sections');
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['section_id']);
        });
    }
}
