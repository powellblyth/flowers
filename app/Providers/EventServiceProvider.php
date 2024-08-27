<?php

namespace App\Providers;

use App\Events\EntrantSaving;
use App\Events\UserSaving;
use App\Listeners\EntrantSubscriptionListener;
use App\Listeners\UserSubscriptionListener;
use App\Models\Category;
use App\Models\MembershipPurchase;
use App\Models\PaymentCard;
use App\Models\RaffleDonor;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\MembershipPurchaseObserver;
use App\Observers\PaymentCardObserver;
use App\Observers\RaffleDonorObserver;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserSaving::class => [
            UserSubscriptionListener::class,
        ],
        EntrantSaving::class => [
            EntrantSubscriptionListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        Category::observe(CategoryObserver::class);
        MembershipPurchase::observe(MembershipPurchaseObserver::class);
        PaymentCard::observe(PaymentCardObserver::class);
        RaffleDonor::observe(RaffleDonorObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
