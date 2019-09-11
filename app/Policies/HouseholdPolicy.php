<?php

namespace App\Policies;

use App\User;
use App\Household;
use Illuminate\Auth\Access\HandlesAuthorization;

class HouseholdPolicy
{
    use HandlesAuthorization;

    private function getSharingLink($user_id, $household_id){
        return \App\HouseholdShare::where('user_id', '=', $user_id)->where('household_id', '=', $household_id)->first();
    }

    /**
     * Determine whether the user can view the household balance.
     *
     * @param  \App\User  $user
     * @param  \App\Household  $household
     * @return mixed
     */
    public function viewBalance(User $user, Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->view_household_balance != null && $options->view_household_balance);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }

    /**
     * Determine whether the user can view the household.
     *
     * @param  \App\User  $user
     * @param  \App\Household  $household
     * @return mixed
     */
    public function view(User $user, Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        return $link != null || $user->id == $household->owner->id;
    }

    /**
     * Determine whether the user can update the household.
     *
     * @param  \App\User  $user
     * @param  \App\Household  $household
     * @return mixed
     */
    public function update(User $user, Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->edit_household != null && $options->edit_household);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }

    /**
     * Determine whether the user can delete the household.
     *
     * @param  \App\User  $user
     * @param  \App\Household  $household
     * @return mixed
     */
    public function delete(User $user, Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->delete_household != null && $options->delete_household);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }
}
