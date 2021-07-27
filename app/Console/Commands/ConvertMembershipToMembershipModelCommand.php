<?php

namespace App\Console\Commands;

use App\Models\Membership;
use App\Models\MembershipPurchase;
use Illuminate\Console\Command;

class ConvertMembershipToMembershipModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:convertMembershipToModel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One off, converts data to match membership model not some arbitrary';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Don't run this twice!
        if (Membership::all()->count() == 0) {
            $twentySeventeenMembershipFamily = Membership::firstOrCreate(['sku' => 'FAMILY_2017'], ['label' => 'Family Membership 2017', 'description' => '2017 Family Membership', 'price_gbp' => 500, 'applies_to' => Membership::APPLIES_TO_USER, 'purchasable_from' => '2017-05-01 00:00:00', 'purchasable_to' => '2018-04-30 23:59:59', 'valid_from' => '2017-06-01 00:00:00', 'valid_to' => '2018-05-31 23:59:59']);
            $twentySeventeenMembershipSingle = Membership::firstOrCreate(['sku' => 'SINGLE_2017'], ['label' => 'Single Membership 2017', 'description' => '2017 Single Membership', 'price_gbp' => 300, 'applies_to' => Membership::APPLIES_TO_ENTRANT, 'purchasable_from' => '2017-05-01 00:00:00', 'purchasable_to' => '2018-04-30 23:59:59', 'valid_from' => '2017-06-01 00:00:00', 'valid_to' => '2018-05-31 23:59:59']);
            $twentyEighteenMembershipFamily  = Membership::firstOrCreate(['sku' => 'FAMILY_2018'], ['label' => 'Family Membership 2018', 'description' => '2018 Family Membership', 'price_gbp' => 500, 'applies_to' => Membership::APPLIES_TO_USER, 'purchasable_from' => '2018-05-01 00:00:00', 'purchasable_to' => '2019-04-30 23:59:59', 'valid_from' => '2018-06-01 00:00:00', 'valid_to' => '2019-05-31 23:59:59']);
            $twentyEighteenMembershipSingle  = Membership::firstOrCreate(['sku' => 'SINGLE_2018'], ['label' => 'Single Membership 2018', 'description' => '2018 Single Membership', 'price_gbp' => 300, 'applies_to' => Membership::APPLIES_TO_ENTRANT, 'purchasable_from' => '2018-05-01 00:00:00', 'purchasable_to' => '2019-04-30 23:59:59', 'valid_from' => '2018-06-01 00:00:00', 'valid_to' => '2019-05-31 23:59:59']);
            $twentyNineteenMembershipFamily  = Membership::firstOrCreate(['sku' => 'FAMILY_2019'], ['label' => 'Family Membership 2019', 'description' => '2019 Family Membership', 'price_gbp' => 500, 'applies_to' => Membership::APPLIES_TO_USER, 'purchasable_from' => '2019-05-01 00:00:00', 'purchasable_to' => '2020-04-30 23:59:59', 'valid_from' => '2019-06-01 00:00:00', 'valid_to' => '2020-05-31 23:59:59']);
            $twentyNineteenMembershipSingle  = Membership::firstOrCreate(['sku' => 'SINGLE_2019'], ['label' => 'Single Membership 2019', 'description' => '2019 Single Membership', 'price_gbp' => 300, 'applies_to' => Membership::APPLIES_TO_ENTRANT, 'purchasable_from' => '2019-05-01 00:00:00', 'purchasable_to' => '2020-04-30 23:59:59', 'valid_from' => '2019-06-01 00:00:00', 'valid_to' => '2020-05-31 23:59:59']);
            $twentyTwentyMembershipFamily    = Membership::firstOrCreate(['sku' => 'FAMILY_2020'], ['label' => 'Family Membership 2020', 'description' => '2020 Family Membership', 'price_gbp' => 500, 'applies_to' => Membership::APPLIES_TO_USER, 'purchasable_from' => '2020-05-01 00:00:00', 'purchasable_to' => '2021-04-30 23:59:59', 'valid_from' => '2020-06-01 00:00:00', 'valid_to' => '2021-05-31 23:59:59']);
            $twentyTwentyMembershipSingle    = Membership::firstOrCreate(['sku' => 'SINGLE_2020'], ['label' => 'Single Membership 2020', 'description' => '2020 Single Membership', 'price_gbp' => 300, 'applies_to' => Membership::APPLIES_TO_ENTRANT, 'purchasable_from' => '2020-05-01 00:00:00', 'purchasable_to' => '2021-04-30 23:59:59', 'valid_from' => '2020-06-01 00:00:00', 'valid_to' => '2021-05-31 23:59:59']);
        }
        $membershipTypes = [
            Membership::APPLIES_TO_ENTRANT => MembershipPurchase::TYPE_INDIVIDUAL,
            Membership::APPLIES_TO_USER => MembershipPurchase::TYPE_FAMILY
        ];
        foreach (Membership::all() as $membership) {
            $this->info("doing " . $membership->label);
            // Find any membership that matches the type (using the type mapper above)
            // And update it to point to the first one
            $this->info('applies_to '.$membership->applies_to);
            $this->info('finding memberships where end_date > \''.$membership->valid_from
                        .'\' AND type=\''.$membershipTypes[$membership->applies_to]
                        .'\' AND start_date < '.$membership->valid_to);
            $membershipPurchases = MembershipPurchase::where('start_date', '<', $membership->valid_to)
                ->where('end_date', '>', $membership->valid_from)
                ->where('type', $membershipTypes[$membership->applies_to])
                ->get();
            $membershipPurchases->each(function (MembershipPurchase $purchase) use ($membership) {
                $this->info("updating membership purchase  " . $membership->label . ' : ' . $purchase->type . ' for member ' . $purchase->user_id . ' entrant ' . $purchase->entrant_id);
                $purchase->membership()->associate($membership);
                $purchase->save();
            });
        }
    }
}
