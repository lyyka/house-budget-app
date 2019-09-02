<?php

namespace App\Observers;

use App\Household;

class HouseholdsObserver
{
    /**
     * Handle the household "created" event.
     *
     * @param  \App\Household  $household
     * @return void
     */
    public function created(Household $household)
    {
        //
    }

    /**
     * Handle the household "updated" event.
     *
     * @param  \App\Household  $household
     * @return void
     */
    public function updated(Household $household)
    {
        //
    }

    /**
     * Handle the household "deleted" event.
     *
     * @param  \App\Household  $household
     * @return void
     */
    public function deleted(Household $household)
    {
        $expenses = $household->expenses;
        foreach ($expenses as $expense) {
            $expense->delete();
        }

        $members = $household->members;
        foreach ($members as $member) {
            $member->delete();
        }
    }

    /**
     * Handle the household "restored" event.
     *
     * @param  \App\Household  $household
     * @return void
     */
    public function restored(Household $household)
    {
        //
    }

    /**
     * Handle the household "force deleted" event.
     *
     * @param  \App\Household  $household
     * @return void
     */
    public function forceDeleted(Household $household)
    {
        //
    }
}
