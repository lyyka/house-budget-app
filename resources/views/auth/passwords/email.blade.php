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
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email">E-Mail Address</label>
                        <input id="email" type="email" class="w-100 rounded shadow-sm border py-2 px-3" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder = "Email to send the password reset link" />
                        @error('email')
                            <label for="email" class="text-danger d-block">{{ $message }}</label>
                        @enderror
                    </div>

                    @if (session('status'))
                        <div class="bg-success px-2 py-3 shadow-sm border rounded text-white">
                            {{ session('status') }}
                        </div>
                    @else
                        <button type="submit" class="rounded shadow-sm py-1 px-3 border bg-info text-white">
                            Send Password Reset Link
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
