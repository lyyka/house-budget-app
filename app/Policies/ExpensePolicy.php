<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
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

    private function getSharingLink($user_id, $household_id){
        return \App\HouseholdShare::where('user_id', '=', $user_id)->where('household_id', '=', $household_id)->first();
    }

    /**
     * Determine whether the user can create expensesfor household.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, \App\Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->add_expenses != null && $options->add_expenses);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }

    /**
     * Determine whether the user can view any expense of household.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user, \App\Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->view_expenses != null && $options->view_expenses);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }

    /**
     * Determine whether the user can delete any expense of household.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, \App\Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->delete_expenses != null && $options->delete_expenses);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }
}
