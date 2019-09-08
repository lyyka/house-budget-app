<?php

namespace App\Policies;

use App\User;
use App\HouseholdMember;
use App\Household;
use Illuminate\Auth\Access\HandlesAuthorization;

class HouseholdMemberPolicy
{
    use HandlesAuthorization;

    private function getSharingLink($user_id, $household_id){
        return \App\HouseholdShare::where('user_id', '=', $user_id)->where('household_id', '=', $household_id)->first();
    }
    
    /**
     * Determine whether the user can view any household members.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewMembersOfHousehold(User $user, Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->view_members != null && $options->view_members);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }

    /**
     * Determine whether the user can create household members.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Household $household)
    {
        $link = $this->getSharingLink($user->id, $household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->add_members != null && $options->add_members);
        }
        else{
            return $user->id == $household->owner->id;
        }
    }

    /**
     * Determine whether the user can update the household member.
     *
     * @param  \App\User  $user
     * @param  \App\HouseholdMember  $householdMember
     * @return mixed
     */
    public function update(User $user, HouseholdMember $householdMember)
    {
        $link = $this->getSharingLink($user->id, $householdMember->household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->edit_members != null && $options->edit_members);
        }
        else{
            return $user->id == $householdMember->household->owner->id;
        }
    }

    /**
     * Determine whether the user can delete the household member.
     *
     * @param  \App\User  $user
     * @param  \App\HouseholdMember  $householdMember
     * @return mixed
     */
    public function delete(User $user, HouseholdMember $householdMember)
    {
        $link = $this->getSharingLink($user->id, $householdMember->household->id);
        if($link != null){
            $options = json_decode($link->permissions);
            return ($options->delete_members != null && $options->delete_members);
        }
        else{
            return $user->id == $householdMember->household->owner->id;
        }
    }
}
