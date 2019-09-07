<?php

namespace App\Providers;

use App\User;
use App\Observers\UserObserver;

use App\HouseholdShare;
use App\Observers\ShareObserver;

use App\Household;
use App\Observers\HouseholdsObserver;

use App\HouseholdMember;
use App\Observers\HouseholdMemberObserver;

use App\Expense;
use App\Observers\ExpensesObserver;

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
        Expense::observe(ExpensesObserver::class);
        HouseholdShare::observe(ShareObserver::class);
        User::observe(UserObserver::class);
    }
}
