<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Config;
use Artisan;
use Schema;
use Cache;
use Auth;

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

        Relation::morphMap([
           'contacts' => 'App\Models\Contact\Contact',
           'invoices' => 'App\Models\Invoice\Invoice'
        ]);

        $settings = Cache::remember('settings:check', 48000, function() {
            return Schema::hasTable('settings');
        });

        if($settings && Auth::check()) {
            // set user timezone
            date_default_timezone_set(settings()->get('application_timezone'));
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
