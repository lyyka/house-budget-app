@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h3>Account Settings</h3>
        <hr />
        <form method="POST" action="/users/{{ Auth::id() }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <label for="first_name" class="d-block">First Name:</label>
                    <input id="first_name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required autofocus placeholder="First Name" />
                    @error('first_name')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="last_name" class="d-block">Last Name:</label>
                    <input id="last_name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" required placeholder="Last Name" />
                    @error('last_name')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
            </div>
    
            <label for="email" class="d-block">Email:</label>
            <input id="email" type="email" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email" placeholder="Enter your email address" />
            @error('email')
                <label class = "d-block text-danger">{{ $message }}</label>
            @enderror
    
            <button type="submit" class="rounded bg-info py-1 px-4 border text-white">
                Update
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