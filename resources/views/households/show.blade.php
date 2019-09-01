@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/households/expense_form.css') }}" />
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">{{ $household->name }}</h1>

        <div class="row">
            <div class="col-lg-6 mb-3">
                @include('components.dashboard.households.money')
            </div>
            <div class="col-lg-6 mb-3">
                @include('components.dashboard.households.add_expense')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/households/expense_form.js') }}"></script>
@endsection