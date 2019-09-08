<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HouseholdSharePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function share(User $user, \App\Household $household){
        $link = \App\HouseholdShare::where('user_id', '=', $user->id)->where('household_id', '=', $household->id)->first();
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->share_with_other_people != null && $options->share_with_other_people);
        }
        else{
            return false || $user->id == $household->owner->id;
        }
    }
}
