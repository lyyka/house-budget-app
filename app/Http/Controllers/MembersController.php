<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getValidationRules($update = false){
        $validation = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'additional_income' => 'nullable|numeric|min:0',
        ];

        if(!$update){
            $validation['household_id'] = 'required|integer|min:1';
        }

        return $validation;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());
        
        $household = \App\Household::findOrFail($request->input('household_id'));

        if($household->user_id == Auth::id()){
            $member = new \App\HouseholdMember();
            $member->household_id = $request->input('household_id');
            $member->first_name = $request->input('first_name');
            $member->last_name = $request->input('last_name');
            $member->additional_income = $request->input('additional_income') != null ? $request->input('additional_income') : 0;
            $member->save();

            toastr()->success('Household member added');
            return redirect()->back();
        }
        else{
            toastr()->error('Error adding a member');
            return redirect('/dahsboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = \App\HouseholdMember::findOrFail($id);
        if($member != null && $member->household->user_id == Auth::id()){
            $household_id = $member->household->id;
            $data = [
                'member' => $member,
                'household_id' => $household_id
            ];

            return view('members.edit')->with($data);
        }
        else{
            toastr()->error('Member not found');
            return redirect('/dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->getValidationRules(true));

        $member = \App\HouseholdMember::findOrFail($id);

        if($member != null && $member->household->user_id == Auth::id()){

            // decrease members household current balance, because observer will increase it by new additional income
            $members_household = $member->household;
            $members_household->current_state -= $member->additional_income;
            $members_household->save();

            $member->first_name = $request->input('first_name');
            $member->last_name = $request->input('last_name');
            $member->additional_income = $request->input('additional_income') != null ? $request->input('additional_income') : 0;
            $member->save();

            toastr()->success('Household member updated');
            return redirect('/households' . '/' . $member->household->id);
        }
        else{
            toastr()->error('Error updating a member');
            return redirect('/dahsboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = \App\HouseholdMember::findOrFail($id);
        if($member->household->user_id == Auth::id()){
            $member->delete();
            toastr()->success('Member removed');
            return redirect()->back();
        }
        else{
            toastr()->error('This is not member of your household');
            return redirect('/dashboard');
        }
    }
}
