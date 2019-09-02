@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/households/expense_form.css') }}" />
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mb-5 pb-5">{{ $household->name }}</h1>

        @include('components.dashboard.households.display_expense')
        @include('components.dashboard.households.add_expense')
        @include('components.dashboard.households.add_member')

        <div class="row">
            <div class="col-lg-6 mb-4">
                @include('components.dashboard.households.money')
            </div>
            <div class="col-lg-6 mb-4">
                @include('components.dashboard.households.members_list')
            </div>
        </div>

        <div class="mb-4">
            @include('components.dashboard.households.expenses_list')
        </div>
    
        <div class="mb-4">
            @include('components.dashboard.households.categories_chart')
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                @include('components.dashboard.households.todays_chart')
            </div>
            <div class="col-lg-6 mb-4">
                @include('components.dashboard.households.current_week_chart')
            </div>
        </div>
        <div class="mb-4">
            @include('components.dashboard.households.monthly_chart')
        </div>
    </div>
@endsection

@section('scripts')
    {{-- form --}}
    <script src="{{ asset('js/households/expense_form.js') }}"></script>

    {{-- load expenses into a modal --}}
    <script src="{{ asset('js/households/expense_list.js') }}"></script>

    {{-- charts --}}
    <script src="{{ asset('js/dashboard/expenses_by_category_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/todays_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/current_week_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/year_chart.js') }}"></script>

    {{-- call monthly and todays chart fetch functions --}}
    <script>
        fetchMonthlyData({{ $household->id }});
        fetchTodaysData({{ $household->id }});
        fetchCurrentWeeksData({{ $household->id }});
        fetchExpensesByCategoryData({{ $household->id }});
    </script>
@endsection