@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/households/expense_form.css') }}" />
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $household->name }}</h1>
        <h5 id="edit_household" class="text-info text-center mb-5 pb-5 cursor-pointer">
            Settings
        </h5>
        <input type="hidden" id="household_id" value="{{ $household->id }}" />

        {{-- modals --}}
        @include('components.dashboard.households.destroy_household')
        @include('components.dashboard.households.edit_household')
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
                @include('components.dashboard.households.daily_chart_by_hour')
            </div>
            <div class="col-lg-6 mb-4">
                @include('components.dashboard.households.custom_range_chart')
            </div>
        </div>
        <div class="mb-4">
            @include('components.dashboard.households.monthly_chart')
        </div>

        {{-- destroy household --}}
        <div class="text-center mb-5">
            <button type="button" class="border rounded shadow-sm bg-light text-dark p-2" data-toggle="modal" data-target="#destroyHouseholdModal">
                Delete this household
            </button>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- edit household button --}}
    <script src="{{ asset('js/households/edit_household.js') }}"></script>

    {{-- form --}}
    <script src="{{ asset('js/households/expense_form.js') }}"></script>

    {{-- load expenses into a modal --}}
    <script src="{{ asset('js/households/expense_list.js') }}"></script>

    {{-- charts --}}
    <script src="{{ asset('js/dashboard/expenses_by_category_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/daily_chart_by_hours.js') }}"></script>
    <script src="{{ asset('js/dashboard/custom_range_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/year_chart.js') }}"></script>

    {{-- call monthly and todays chart fetch functions --}}
    <script>
        fetchMonthlyData({{ $household->id }}, (new Date()).getFullYear());
        fetchDailyData({{ $household->id }});
        fetchCustomRangeData({{ $household->id }});
        fetchExpensesByCategoryData({{ $household->id }});
    </script>
@endsection