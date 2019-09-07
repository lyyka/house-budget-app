<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HouseholdSharingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $household_id)
    {
        $request->validate([
            'share_to_email' => 'required|email|max:191',
            'sharing_permissions' => 'array|required|max:9',
            'sharing_permissions.*' => 'string|exists:sharing_permissions_list,name'
        ]);

        $household = \App\Household::findOrFail($household_id);
        if($household != null && $household->authUserHasAccess()){
            $email = $request->input('share_to_email');
            if($email == Auth::user()->email){
                toastr()->error('You can not share household with yourself');
            }
            else{
                $sharing_permisssions = $request->input('sharing_permissions');
                $all_permissions = \App\SharingPermission::all();
                $json_permissions = [];
                foreach($all_permissions as $perm){
                    $key = strtolower(str_replace(" ", "_", $perm->name));
                    $json_permissions[$key] = in_array($perm->name, $sharing_permisssions);
                }

                $share = new \App\HouseholdShare();
                $share->household_id = $household_id;
                $share->shared_with_email = $email;
                $share->permissions = json_encode($json_permissions);
                $share->save();
                toastr()->success('Household shared successfully');
            }
        }
        else{
            toastr()->error('Access denied');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $share = \App\HouseholdShare::findOrFail($id);
        if($share != null && $share->household->owner->id == Auth::id()){
            $email = $share->shared_with_email;
            $share->delete();
            toastr()->success("Acces revoked for " . $email);
        }
        else{
            toastr()->error("Access denied");
        }
        return redirect()->back();
    }
}
