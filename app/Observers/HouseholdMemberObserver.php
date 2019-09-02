<?php

namespace App\Observers;

use App\HouseholdMember;

class HouseholdMemberObserver
{
    /**
     * Handle the household member "created" event.
     *
     * @param  \App\HouseholdMember  $householdMember
     * @return void
     */
    public function created(HouseholdMember $householdMember)
    {
        $household = $householdMember->household;
        $household->current_state += $householdMember->additional_income;
        $household->save();
    }

    /**
     * Handle the household member "updated" event.
     *
     * @param  \App\HouseholdMember  $householdMember
     * @return void
     */
    public function updated(HouseholdMember $householdMember)
    {
        $household = $householdMember->household;
        $household->current_state += $householdMember->additional_income;
        $household->save();
    }

    /**
     * Handle the household member "deleted" event.
     *
     * @param  \App\HouseholdMember  $householdMember
     * @return void
     */
    public function deleted(HouseholdMember $householdMember)
    {
        //
    }

    /**
     * Handle the household member "restored" event.
     *
     * @param  \App\HouseholdMember  $householdMember
     * @return void
     */
    public function restored(HouseholdMember $householdMember)
    {
        //
    }

    /**
     * Handle the household member "force deleted" event.
     *
     * @param  \App\HouseholdMember  $householdMember
     * @return void
     */
    public function forceDeleted(HouseholdMember $householdMember)
    {
        //
    }
}
