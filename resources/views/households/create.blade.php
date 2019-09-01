@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h3>Add a Household</h3>
        <hr />
        <form method="POST" action="/households">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <label for="name" class="d-block">Name a household:</label>
                    <input id="name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Use a name to recognize this household" />
                    @error('name')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="currency" class="d-block">Default currency:</label>
                    <select name="currency" id="currency" class="mb-4 w-100 rounded shadow-sm border py-2 px-3">
                        @foreach ($currencies as $curr)
                            <option value="{{ $curr->id }}">{{ $curr->currency_name }} ({{ $curr->currency_short }})</option>
                        @endforeach
                    </select>
                    @error('currency')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label for="monthly_income" class="d-block">Monthly Income:</label>
                    <input id="monthly_income" type="number" min="100" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('monthly_income') is-invalid @enderror" name="monthly_income" value="{{ old('monthly_income') }}" required placeholder="Income" />
                    @error('monthly_income')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="expected_monthly_savings" class="d-block">Expected Monthly Savings:</label>
                    <input id="expected_monthly_savings" min="100" type="number" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('expected_monthly_savings') is-invalid @enderror" name="expected_monthly_savings" value="{{ old('expected_monthly_savings') }}" required placeholder="How much do you expect to save?" />
                    @error('expected_monthly_savings')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <label for="current_state" class="d-block">Current Budget State (optional):</label>
                    <input id="current_state" type="number" class="w-100 rounded shadow-sm border py-2 px-3 @error('current_state') is-invalid @enderror" name="current_state" value="{{ old('current_state') }}" placeholder="How much do you expect to save?" />
                    <label class = "text-muted">Defaults to monthly income</label>
                    @error('current_state')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="budget_reset_day" class="d-block">When is the budget reset?</label>
                    <input id="budget_reset_day" type="number" min="1" max="31" class="w-100 rounded shadow-sm border py-2 px-3 @error('budget_reset_day') is-invalid @enderror" name="budget_reset_day" value="{{ old('budget_reset_day') }}" required placeholder="How much do you expect to save?" />
                    @error('budget_reset_day')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
            </div>
            <button type="submit" class="px-3 py-1 rounded shadow-sm text-white bg-info border">
                Create a household
            </button>
        </form>
    </div>
@endsection