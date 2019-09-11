@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <a href="/households/{{ $household_id }}" class="text-dark d-block mb-4"><i class="fas fa-angle-left"></i> Go Back</a>
            <form method="POST" action="/members/{{ $member->id }}">
                @csrf
                @method("PUT")

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <label for="first_name" class="d-block">First Name:</label>
                        <input id="first_name" type="text" class="w-100 rounded shadow-sm border py-2 px-3 @error('first_name') is-invalid @enderror" name="first_name" required autofocus placeholder="First Name" value = "{{ old('first_name', $member->first_name) }}" />
                        @error('first_name')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="last_name" class="d-block">Last Name:</label>
                        <input id="last_name" type="text" class="w-100 rounded shadow-sm border py-2 px-3 @error('last_name') is-invalid @enderror" name="last_name" required autofocus placeholder="Last Name" value = "{{ old('last_name', $member->last_name) }}" />
                        @error('last_name')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
        
                <div class="mb-4">
                    <label for="additional_income" class="d-block">Additional Income:</label>
                    <input id="additional_income" type="number" min="1" class="w-100 rounded shadow-sm border py-2 px-3 @error('additional_income') is-invalid @enderror" name="additional_income" required autofocus placeholder="How much does the member make?" value = "{{ old('additional_income', $member->additional_income) }}" />
                    <label class="text-muted">{{ $member->household->currency->currency_short }}</label>
                    @error('additional_income')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>

                <button type="submit" class="rounded bg-info py-1 px-4 border text-white">
                    Update
                </button>
            </form> 
        </div>
    </div>
@endsection