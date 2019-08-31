@extends('layouts.main')

@section('content')
<div class="container my-5 py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <a href="/" class="text-dark d-block mb-4"><i class="fas fa-angle-left"></i> Home</a>
            <div class="rounded shadow-sm border p-4">
                <div class="text-center">
                    <img src="{{ asset('storage/images/register.png') }}" alt="Register" class="img-fluid" />
                </div>
                <hr />
                <form method="POST" action="{{ route("register") }}">
                    @csrf
    
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="first_name" class="d-block">First Name:</label>
                            <input id="first_name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="First Name" />
                            @error('first_name')
                                <label class = "d-block text-danger">{{ $error }}</label>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label for="last_name" class="d-block">Last Name:</label>
                            <input id="last_name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required placeholder="Last Name" />
                            @error('last_name')
                                <label class = "d-block text-danger">{{ $error }}</label>
                            @enderror
                        </div>
                    </div>
        
                    <label for="email" class="d-block">Email:</label>
                    <input id="email" type="email" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address" />
                    @error('email')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
        
                    <label for="password" class="d-block">Password:</label>
                    <input id="password" type="password" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your password here" />
                    @error('password')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
    
                    <label for="password-confirm" class="d-block">Repeat Password:</label>
                    <input id="password-confirm" type="password" class="w-100 mb-4 rounded shadow-sm border py-2 px-3" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password" />
    
                    <button type="submit" class="w-100 rounded bg-success py-1 px-4 border text-white">
                        Register
                    </button>
    
                    <hr />
    
                    <p class="m-0">
                        Already have an account?
                        <a href="/login">
                            Log In!
                        </a>
                    </p>
                </form> 
            </div>
        </div>
    </div>
</div>
@endsection
