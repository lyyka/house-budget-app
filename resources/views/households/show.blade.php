@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/households/expense_form.css') }}" />
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mb-5 pb-5">{{ $household->name }}</h1>

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
        <div class="mb-4">
            @include('components.dashboard.households.todays_chart')
        </div>
        <div class="mb-4">
            @include('components.dashboard.households.monthly_chart')
        </div>
    </div>
@endsection

@section('scripts')
    {{-- categories/expense chart --}}
    <script>
        let category_labels = [];
        let category_values = [];
        let category_colors = [];

        @foreach($expenses_by_category as $exp)
            @php
                $amount = $exp->total;
                $category = $exp->category_name;
                $color = $exp->category_color;
            @endphp
            category_labels.push("{{ $category }}");
            category_values.push({{ $amount }});
            category_colors.push("#{{ $color }}");
        @endforeach

        // init this month chart
        const ctx = document.getElementById('categories_chart').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',
        
            // The data for our dataset
            data: {
                labels: category_labels,
                datasets: [{
                    label: 'Money spent by category',
                    backgroundColor: category_colors,
                    // borderColor: 'rgb(79, 235, 149)',
                    data: category_values
                }]
            },
        
            // Configuration options go here
            options: {
                legend: {
                    display: false
                },
                animation: {
                    duration: 2000
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    barPercentage: 0.7,
                }
            }
        });
    </script>
    <script src="{{ asset('js/households/expense_form.js') }}"></script>
@endsection