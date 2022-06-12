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
        DB::table('membership_purchases')
            ->whereIn('membership_id', [3, 5, 7])
            ->update(['membership_id' => 1]);
        DB::table('membership_purchases')
            ->whereIn('membership_id', [4, 6, 8])
            ->update(['membership_id' => 2]);
        //

        DB::table('memberships')
            ->where('id', '>', 2)
            ->delete();

        Schema::table('memberships', function (Blueprint $table) {
            $table->string('stripe_id')->after('sku')->nullable();
            $table->string('stripe_price')->after('stripe_id')->nullable();
            $table->dropColumn(['valid_from', 'valid_to', 'purchasable_from', 'purchasable_to']);
        });

        DB::table('memberships')
            ->where('id', 1)
            ->update([
                'sku' => 'FAMILY',
                'stripe_id' => 'prod_LcUq59MNLmfJCi',
                'stripe_price' => 'price_1L5ZC1HJv0e8AgMdRMY8cJsA',
                'label' => 'Family Membership',
                'description' => 'Family membership of the Petersham Horti',
            ]);
        DB::table('memberships')
            ->where('id', 2)
            ->update([
                'sku' => 'SINGLE',
                'stripe_id' => 'prod_LcUq59MNLmfJCi',
                'stripe_price' => 'price_1KvFquHJv0e8AgMd4gm98gtH',
                'label' => 'Single Membership',
                'description' => 'Single membership of the Petersham Horti',
            ]);
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn(['stripe_id', 'stripe_price']);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->dateTime('purchasable_from')->nullable();
            $table->dateTime('purchasable_to')->nullable();
        });
    }
};
