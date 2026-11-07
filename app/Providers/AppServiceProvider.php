<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
   public function register(): void    {        // Load global helpers (money()) even if Composer's autoload cache is stale.        
   require_once dirname(__DIR__).'/helpers.php';      
     $this->app->singleton(CurrencyService::class);    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
