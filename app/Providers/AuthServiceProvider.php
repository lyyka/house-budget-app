<?php

namespace App\Providers;

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
        \App\Household::class => \App\Policies\HouseholdPolicy::class,
        \App\HouseholdMember::class => \App\Policies\HouseholdMemberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Household Member
        Gate::define('add-members', 'App\Policies\HouseholdMemberPolicy@create');
        Gate::define('view-members', 'App\Policies\HouseholdMemberPolicy@viewMembersOfHousehold');
        Gate::define('edit-members', 'App\Policies\HouseholdMemberPolicy@update');
        Gate::define('delete-members', 'App\Policies\HouseholdMemberPolicy@delete');

        // Household
        Gate::define('view-household', 'App\Policies\HouseholdPolicy@view');
        Gate::define('view-household-balance', 'App\Policies\HouseholdPolicy@viewBalance');
        Gate::define('edit-household', 'App\Policies\HouseholdPolicy@update');
        Gate::define('delete-household', 'App\Policies\HouseholdPolicy@delete');

        // Charts
        Gate::define('view-charts', 'App\Policies\ChartsPolicy@viewCharts');

        // Expenses
        Gate::define('add-expense', 'App\Policies\ExpensePolicy@create');
        Gate::define('view-expense', 'App\Policies\ExpensePolicy@view');
        Gate::define('delete-expense', 'App\Policies\ExpensePolicy@delete');

        // Sharing
        Gate::define('share-household', 'App\Policies\HouseholdSharePolicy@share');
    }
}
