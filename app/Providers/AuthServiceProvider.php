<?php

namespace App\Providers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\MembershipPurchase;
use App\Policies\CategoryPolicy;
use App\Policies\CupPolicy;
use App\Policies\EntrantPolicy;
use App\Policies\EntryPolicy;
use App\Policies\MembershipPurchasePolicy;
use App\Policies\ShowPolicy;
use App\Policies\TeamPolicy;
use App\Cup;
use App\Policies\UserPolicy;
use App\Show;
use App\Team;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model'                     => 'App\Policies\ModelPolicy',
        Category::class                 => CategoryPolicy::class,
        Cup::class                      => CupPolicy::class,
        Entrant::class                  => EntrantPolicy::class,
        Entry::class                    => EntryPolicy::class,
        MembershipPurchasePolicy::class => MembershipPurchase::class,
        Show::class                     => ShowPolicy::class,
        Team::class                     => TeamPolicy::class,
        User::class                     => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
