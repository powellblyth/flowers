<?php

namespace App\Providers;

use App\Models\Model;
use App\Services\MailChimpService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use NZTim\Mailchimp\Mailchimp;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
//        Model::preventLazyLoading(!app()->isProduction());
//        Cashier::useCurrency('gbp', '£');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MailChimpService::class,
            fn() => new MailChimpService(
                new Mailchimp(
                    config('mailchimp.apikey')
                ),
                config('flowers.mailchimp.mailing_list_id'),
            )
        );
    }
}
