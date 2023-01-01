<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Cashier\SubscriptionItem;
use Stripe\Product;
use Stripe\StripeClient;

/**
 * https://stripe.com/docs/api/products?lang=php
 */
class SyncProductsCommand extends Command
{
    private StripeClient $stripe;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:syncproducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates pricing and product information from Stripe';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->stripe = new StripeClient(config('stripe.api_key_secret'));

//        Subscription::whereNull('stripe_id')->get()->each(function (Subscription $subscription) {
//            $this->stripe->products->create([
//                'name' => $subscription->name,
//                'description' => $subscription->description,
//                'active' => $subscription->status === Subscription::STATUS_ACTIVE,
//            ]);
//        });
        $plansraw = $this->stripe->plans->all();
        $plans = $plansraw->data;

        foreach ($plans as $plan) {
            $plan->product = $this->stripe->products->retrieve(
                $plan->product, []
            );
        }
        dd($plans);

        collect($this->stripe->products->all()->data)->each(function (Product $product) {
            /** @var SubscriptionItem $subscription */
            $subscription = \Laravel\Cashier\SubscriptionItem::where('stripe_id', $product->id)->firstOrNew();
            dump($subscription);
            $subscription->updateQuietly();
//            $subscription = Subscription::where('stripe_id', $product->id)->firstOrNew();
//            $subscription->name = $product->name;
//            $subscription->description = $product->description;
//            $subscription->status = $product->active ? Subscription::STATUS_ACTIVE : Subscription::STATUS_RETIRED;
//            $subscription->save();
        });

        return 0;
    }
}
