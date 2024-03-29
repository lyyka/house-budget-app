@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/households/expense_form.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="mb-5 pb-5 text-center">
            <h1 class="d-inline-block">
                {{ $household->name }}
            </h1>
            @if (Auth::user()->can('edit-household', $household) || Auth::user()->can('share-household', $household))
                <div class="ml-3 cursor-pointer d-inline-block position-relative">
                    <div class="dropdown">
                        <button id="household_actions" class="bg-transparent border-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="h3">
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="household_actions">
                            @can('edit-household', $household)
                                <a class="dropdown-item" href="javascript:void(0)" id = "edit_household">
                                    <i class="fas fa-cogs"></i> 
                                    Settings
                                </a>
                            @endcan
                            @can('share-household', $household)
                                <a class="dropdown-item" href="javascript:void(0)" id = "share_household">
                                    <i class="fas fa-share-alt"></i> 
                                    Share
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" id = "shared_with">
                                    <i class="fas fa-users"></i> 
                                    Shared With
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <input type="hidden" id="household_id" value="{{ $household->id }}" />

        {{-- modals --}}
        @can('view-expense', $household)
            @include('components.dashboard.households.modals.import_from_xlsx')
            @include('components.dashboard.households.modals.export_to_xlsx')
        @endcan
    
        @can('delete-household', $household)
            @include('components.dashboard.households.modals.destroy_household')
        @endcan
    
        @include('components.dashboard.households.modals.shared_with_list')
        @include('components.dashboard.households.modals.share_household')
    
        @can('edit-household', $household)
            @include('components.dashboard.households.modals.edit_household')
        @endcan
    
        @can('view-expense', $household)
            @include('components.dashboard.households.modals.display_expense')
        @endcan

        @can('add-expense', $household)
            @include('components.dashboard.households.modals.add_expense')
        @endcan

        @can('add-members', $household)
            @include('components.dashboard.households.modals.add_member')
        @endcan

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
    
        @can('view-charts', $household)
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
        @endcan
        
        @can('delete-household', $household)
            {{-- destroy household --}}
            <div class="text-center mb-5">
                <button type="button" class="border-0 text-muted bg-transparent text-dark p-2" data-toggle="modal" data-target="#destroyHouseholdModal">
                    Delete this household
                </button>
            </div>
        @endcan
    </div>
@endsection

@section('scripts')
    @if (Auth::user()->hasVerifiedEmail())
        <script src="{{ asset('js/households/import_from_excel.js') }}"></script>
        {{-- excel to get file AJAX --}}
        <script src="{{ asset('js/households/export_to_excel.js') }}"></script>
    @endif

    {{-- edit household button --}}
    <script src="{{ asset('js/households/household_actions_menu.js') }}"></script>

    {{-- form --}}
    @can('add-expense', $household)
        <script src="{{ asset('js/households/expense_form.js') }}"></script>
    @endcan

    {{-- load expenses into a modal --}}
    @can('view-expense', $household)
        <script src="{{ asset('js/households/expense_list.js') }}"></script>
    @endcan

    {{-- charts --}}
    @can('view-charts', $household)
        <script src="{{ asset('js/dashboard/expenses_by_category_chart.js') }}"></script>
        <script src="{{ asset('js/dashboard/daily_chart_by_hours.js') }}"></script>
        <script src="{{ asset('js/dashboard/custom_range_chart.js') }}"></script>
        <script src="{{ asset('js/dashboard/year_chart.js') }}"></script>
        
        <script>
            fetchMonthlyData({{ $household->id }}, (new Date()).getFullYear());
            fetchDailyData({{ $household->id }});
            fetchCustomRangeData({{ $household->id }});
            fetchExpensesByCategoryData({{ $household->id }});
        </script>
    @endcan

    
@endsection