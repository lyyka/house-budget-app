<?php

namespace App\Providers;

use App\Household;
use App\Observers\HouseholdsObserver;

use App\HouseholdMember;
use App\Observers\HouseholdMemberObserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        Household::observe(HouseholdsObserver::class);
        HouseholdMember::observe(HouseholdMemberObserver::class);
    }
}
