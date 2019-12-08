@extends('layouts.auth_pages')

@section('content')
<div class="container my-5 py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <a href="/" class="text-dark d-block mb-4"><i class="fas fa-angle-left"></i> Home</a>
            <div class="rounded shadow-sm border p-4 bg-white">
                <h5 class="text-center text-dark h1 font-lobster mb-5">
                    HouseBudget
                </h5>
                <form method="POST" action="{{ route("login") }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="d-block">Email:</label>
                        <input id="email" type="email" class="w-100 rounded shadow-sm border py-2 px-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address" />
                        @error('email')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="password" class="d-block">Password:</label>
                        <input id="password" type="password" class="w-100 rounded shadow-sm border py-2 px-3 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password here" />
                        @error('password')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
        
                    {{-- <hr /> --}}
        
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                    <label for="remember">
                        Remember Me
                    </label>
                    <br />
    
                    <button type="submit" class="w-100 rounded bg-success py-1 px-4 border text-white">
                        Log In
                    </button>
    
                    <hr />
    
                    <p class="m-0">
                        Don't have an account?
                        <a href="/register" class="text-info">
                            Register!
                        </a>
                    </p>
                    <a href="{{ route('password.request') }}" class="text-info">
                        Forgot Your Password?
                    </a>
                </form> 
            </div>
        </div>
    </div>
</div>
@endsection
