@extends('layouts.auth_pages')

@section('content')
<div class="container my-5 py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <a href="/login" class="text-dark d-block mb-4"><i class="fas fa-angle-left"></i> Login page</a>
            <div class="rounded shadow-sm border p-4 bg-white">
                <h5 class="text-center text-dark h1 font-lobster mb-5">
                    HouseBudget
                </h5>
                @foreach ($errors->all() as $err)
                    <label for="email" class="text-danger d-block">{{ $err }}</label>
                @endforeach
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input id="email" type="hidden" name="email" value="{{ $email ?? old('email') }}" required />
                    @error('email')
                        <label for="email" class="text-danger d-block">{{ $message }}</label>
                    @enderror

                    <div class="mb-4">
                        <label for="password">Password: <span class="text-info">*</span></label>
                        <input id="password" type="password" class="w-100 rounded shadow-sm border py-2 px-3" name="password" required autocomplete="new-password" placeholder = "Your new password" />
                        @error('password')
                            <label for="email" class="text-danger d-block">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation">Confirm Password: <span class="text-info">*</span></label>
                        <input id="password_confirmation" type="password" class="w-100 rounded shadow-sm border py-2 px-3" name="password_confirmation" required autocomplete="new-password" placeholder = "Confirm your password" />
                    </div>

                    <button type="submit" class="rounded shadow-sm py-1 px-3 border bg-info text-white">
                        Reset the password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
