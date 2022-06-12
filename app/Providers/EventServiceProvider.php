<?php

namespace App\Providers;

use App\Events\EntrantSaving;
use App\Events\UserSaving;
use App\Listeners\EntrantSubscriptionListener;
use App\Listeners\UserSubscriptionListener;
use App\Models\PaymentCard;
use App\Models\User;
use App\Observers\PaymentCardObserver;
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
        UserSaving::class    => [
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
    public function boot()
    {
        parent::boot();
        User::observe(UserObserver::class);
        PaymentCard::observe(PaymentCardObserver::class);
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
