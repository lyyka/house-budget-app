@extends('layouts.dashboard')

@section('content')

{{-- dashboard --}}
<div class="container">
    <div class="row">
        <div class="col-lg-6 mb-5">
            @include('components.dashboard.index.quick_households')
        </div>
        <div class="col-lg-6 mb-5">
            @include('components.dashboard.index.today_overview')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-5">
            @include('components.dashboard.index.monthly_overview')
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset("js/dashboard/todays_chart.js") }}"></script>
    <script src="{{ asset("js/dashboard/year_chart.js") }}"></script>
@endsection
