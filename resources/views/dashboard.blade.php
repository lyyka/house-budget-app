@extends('layouts.dashboard')

@section('content')

{{-- dashboard --}}
<div class="container">
    <div class="mb-5 pb-5">
        <h1 class="text-center">Dashboard</h1>
        @if (Auth::user()->hasVerifiedEmail())
            <p class="text-success text-center">
                <i class="fas fa-shield-alt"></i>
                Account Verified
            </p>
        @else
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    A fresh verification link has been sent to your email address
                </div>
            @endif

            <p class="text-center">
                Before proceeding, please check your email for a verification link. <br />
                If you did not receive the email, <a class="text-info" href="{{ route('verification.resend') }}">click here to request another</a>.
            </p>
        @endif
    </div>
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
    @if (Auth::user()->hasVerifiedEmail())
        <script src="{{ asset('js/dashboard/expenses_by_category_chart.js') }}"></script>
        <script src="{{ asset('js/dashboard/custom_range_chart.js') }}"></script>
        <script src="{{ asset("js/dashboard/year_chart.js") }}"></script>
    @endif
    <script src="{{ asset("js/dashboard/daily_chart_by_hours.js") }}"></script>
@endsection
