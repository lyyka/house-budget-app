<?php

namespace App\Observers;

use App\Household;
use Illuminate\Support\Facades\Mail;

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
        // check if the current state dropped low
        if($household->current_state <= 0 || $household->current_state <= $household->expected_monthly_savings){
            $email = $household->owner->email;
            $options = json_decode($household->options);
            if($options != null && $options->allow_low_balance_emails && $household->owner->hasEmailVerified()){
                Mail::to($email)->send(new \App\Mail\HouseholdStateLow($household));
            }
        }
    }

    /**
     * Handle the household "deleted" event.
     *
     * @param  \App\Household  $household
     * @return void
     */
    public function deleted(Household $household)
    {
        //
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
