<?php

namespace App\Observers;

use App\HouseholdShare;
use Illuminate\Support\Facades\Mail;

class ShareObserver
{
    /**
     * Handle the household share "created" event.
     *
     * @param  \App\HouseholdShare  $householdShare
     * @return void
     */
    public function created(HouseholdShare $householdShare)
    {
        $email = $householdShare->shared_with_email;
        
        // if the user exists, grab his id and set it on user_id col
        $user = \App\User::where('email', '=', $email)->first();
        if($user != null){
            $householdShare->user_id = $user->id;
            $householdShare->save();
        }

        Mail::to($email)->send(new \App\Mail\HouseholdShared($householdShare));
    }

    /**
     * Handle the household share "updated" event.
     *
     * @param  \App\HouseholdShare  $householdShare
     * @return void
     */
    public function updated(HouseholdShare $householdShare)
    {
        //
    }

    /**
     * Handle the household share "deleted" event.
     *
     * @param  \App\HouseholdShare  $householdShare
     * @return void
     */
    public function deleted(HouseholdShare $householdShare)
    {
        Mail::to($householdShare->shared_with_email)->send(new \App\Mail\HouseholdShareRevoked($householdShare));
    }

    /**
     * Handle the household share "restored" event.
     *
     * @param  \App\HouseholdShare  $householdShare
     * @return void
     */
    public function restored(HouseholdShare $householdShare)
    {
        //
    }

    /**
     * Handle the household share "force deleted" event.
     *
     * @param  \App\HouseholdShare  $householdShare
     * @return void
     */
    public function forceDeleted(HouseholdShare $householdShare)
    {
        //
    }
}
