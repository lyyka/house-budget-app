@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h3>Add a Household</h3>
        <hr />
        <form method="POST" action="/households">
            @csrf
            <label for="name" class="d-block">Name a household:</label>
            <input id="name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Use a name to recognize this household" />
            @error('name')
                <label class = "d-block text-danger">{{ $error }}</label>
            @enderror
            <div class="row">
                <div class="col-lg-6">
                    <label for="monthly_income" class="d-block">Monthly Income:</label>
                    <select name="currency" id="currency" class="mb-4 rounded shadow-sm border py-2 px-3">
                        <option value="USD">USD</option>
                        <option value="RSD">RSD</option>
                    </select>
                    <input id="monthly_income" type="number" class="w-50 mb-4 rounded shadow-sm border py-2 px-3 @error('monthly_income') is-invalid @enderror" name="monthly_income" value="{{ old('monthly_income') }}" required autofocus placeholder="Income" />
                    @error('monthly_income')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <input id="monthly_income" type="number" class="w-50 mb-4 rounded shadow-sm border py-2 px-3 @error('monthly_income') is-invalid @enderror" name="monthly_income" value="{{ old('monthly_income') }}" required autofocus placeholder="Income" />
                    @error('monthly_income')
                        <label class = "d-block text-danger">{{ $error }}</label>
                    @enderror
                </div>
            </div>
        </form>
    </div>
@endsection