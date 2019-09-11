@extends('layouts.dashboard')

@section('content')
    <div class="container rounded shadow-sm border bg-white p-4 my-5">
        <h3>Account Settings</h3>
        <hr />
        <form method="POST" action="/users/{{ Auth::id() }}" class="mb-5">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <label for="first_name" class="d-block">First Name:</label>
                    <input id="first_name" type="text" class="w-100 rounded shadow-sm border py-2 px-3 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required autofocus placeholder="First Name" />
                    @error('first_name')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-lg-6 mb-4">
                    <label for="last_name" class="d-block">Last Name:</label>
                    <input id="last_name" type="text" class="w-100 rounded shadow-sm border py-2 px-3 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" required placeholder="Last Name" />
                    @error('last_name')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
    
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <label for="email" class="d-block">Email:</label>
                    <input id="email" type="email" class="w-100 rounded shadow-sm border py-2 px-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email" placeholder="Enter your email address" />
                    @error('email')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
    
            <button type="submit" class="rounded bg-info py-1 px-4 border text-white">
                Update
            </button>
        </form> 

        <h3>Password Reset</h3>
        <hr />
        <form method="POST" action="/users/{{ Auth::id() }}/password/new">
            @csrf
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <label for="old_password" class="d-block">Current Password:</label>
                    <input id="old_password" type="password" class="w-100 rounded shadow-sm border py-2 px-3 @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="current-password" placeholder="Your Current Password" />
                    @error('old_password')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <label for="password" class="d-block">New Password:</label>
                    <input id="password" type="password" class="w-100 rounded shadow-sm border py-2 px-3 @error('password') is-invalid @enderror" name="password" required placeholder="New Password" autocomplete="new-password" />
                    @error('password')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <label for="password_confirmation" class="d-block">Repeat New Password:</label>
                    <input id="password_confirmation" type="password" class="w-100 rounded shadow-sm border py-2 px-3 @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required placeholder="Confirm New Password" />
                </div>
            </div>
            <button type="submit" class="rounded bg-info py-1 px-4 border text-white">
                Reset
            </button>
        </form>
        <hr />
        <form action="/users/{{ Auth::id() }}" method="POST" class="text-center">
            @csrf
            @method("DELETE")
            <button type="submit" class="border-0 text-muted bg-transparent">
                Deactivate account
            </button>
        </form>
    </div>
@endsection