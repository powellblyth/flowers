<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('label')->nullable();
            $table->string('description')->nullable();
            $table->unsignedMediumInteger('price_gbp')->nullable();
            $table->string('applies_to')->nullable();
            $table->dateTime('purchasable_from')->nullable();
            $table->dateTime('purchasable_to')->nullable();
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('membership_id')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership_purchases', function (Blueprint $table) {
            $table->dropColumn(['membership_id']);
        });
        Schema::dropIfExists('memberships');
    }
}
