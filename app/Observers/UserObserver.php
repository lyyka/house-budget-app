<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // if the user is craeted, grab all share links that have his email address and set user id
        $email = $user->email;
        $shares_with_this_email = \App\HouseholdShare::where('shared_with_email', '=', $email)->get();
        foreach ($shares_with_this_email as $share) {
            $share->user_id = $user->id;
            $share->save();
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $shares_with_this_email = \App\HouseholdShare::where('shared_with_email', '=', $user->email)->get();
        foreach ($shares_with_this_email as $share) {
            $share->shared_with_email = $user->email;
            $share->save();
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
