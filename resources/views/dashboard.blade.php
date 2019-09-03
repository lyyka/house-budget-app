@extends('layouts.dashboard')

@section('content')

{{-- dashboard --}}
<div class="container">
    <div class="row">
        <div class="col-lg-6 mb-5">
            @include('components.dashboard.index.quick_households')
        </div>
        <div class="col-lg-6 mb-5">
            @include('components.dashboard.index.daily_chart_by_hour')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-5">
            @include('components.dashboard.index.custom_range_chart')
        </div>
        <div class="col-lg-6 mb-5">
            @include('components.dashboard.index.monthly_overview')
        </div>
    </div>
    <div class="mb-5">
        @include('components.dashboard.index.categories_chart')
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/expenses_by_category_chart.js') }}"></script>
    <script src="{{ asset('js/dashboard/custom_range_chart.js') }}"></script>
    <script src="{{ asset("js/dashboard/daily_chart_by_hours.js") }}"></script>
    <script src="{{ asset("js/dashboard/year_chart.js") }}"></script>
@endsection
