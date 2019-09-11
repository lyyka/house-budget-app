<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

class UsersController extends Controller
{

    public function __construct(){
        return $this->middleware('auth');
    }

    /**
     * Display edit page for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::id() == $id){
            return view('users.edit');
        }
    }

    public function resetPassword(Request $request, $id){
        if(!Auth::user()->hasVerifiedEmail()){
            toastr()->error('You msut verify your email address');
            return redirect()->back();
        }

        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $old_password = $request->input('old_password');
        $new_password = $request->input('password');

        if(Auth::user()->id == $id){
            // retrieve user
            $user = \App\User::findOrFail($id);

            // check current password
            if(Hash::check($old_password, $user->password)){
                // check if new password is same
                $new_is_same = Hash::check($new_password, $user->password);

                if($new_is_same){
                    toastr()->error("New password is same as the current one");
                    return redirect()->back();
                }
                else{
                    $user->password = Hash::make($new_password);
                    $user->save();
                    toastr()->success('Your password has been updated');
                    return redirect()->back();
                }
            }
            else{
                toastr()->error("Current password is not valid");
                // current password not good
                return redirect()->back();
            }
        }
        else{
            toastr()->error("Access Denied");
            return redirect()->back();
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
        if(Auth::id() == $id){
            $request->validate([
                'first_name' => ['required', 'string', 'max:191'],
                'last_name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,' . $id],
            ]);

            $user = Auth::user();

            if($user->email != $request->input('email')){
                $user->email_verified_at = null;
            }

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');

            // see if dirty and generate feedback message
            $message = $user->isDirty() ? 'Account updated successfully' : "Nothing to update. You're all set!";

            $user->save();

            toastr()->success($message);
            return redirect("/users" . "/" . $id . "/edit");
        }
        else{
            toastr()->error('Access denied!');
            return redirect()->back();
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
        if($id == Auth::id()){
            if(Auth::user()->hasVerifiedEmail()){
                // destroy
                $user->delete();

                // log out
                Auth::logout();

                toastr()->success('Account has been deactiavted');
                return redirect('/');
            }
            else{
                toastr()->error('Please verify your email address first');
                return redirect()->back();
            }
        }
        else{
            toastr()->error('Access denied');
            return redirect()->back();
        }
    }
}
