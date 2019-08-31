@extends('layouts.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset("css/pages/index.css") }}">
@endsection

@section('content')
    <div class="py-5 position-relative" id="main_ribbon">
        <div class="position-absolute abs-center-middle bg-white p-4 rounded shadow-sm border">
            <h2 class="text-center">
                Welcome to House Budget
            </h2>
            <p class="text-center">Manage all you household expenses in one place!</p>
            <div class="text-center">
                <a href="/login" class="rounded shadow-sm border py-2 px-4 bg-success text-white">
                    Log In
                </a>
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-4 mb-3 animated fadeInLeft">
                    <img src="{{ asset('storage/images/money_design.png') }}" alt="Money Image" class="img-fluid" />
                </div>
                <div class="col-lg-8 mb-3 animated fadeInRight">
                    <h3>Import all your expenses in your system</h3>
                    <hr />
                    <p>Using a simple UI you can easily import all expenses for your household. This way you can get detailed expenses report over time using our application!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-3 order-lg-1 order-2 order-md-2 order-sm-2 animated fadeInLeft">
                    <h3>Gain insight into your expenses</h3>
                    <hr />
                    <p>Using our app for a longer period of time, it will start to generate more detailed expense report based on your income/expenses. This can help tremendously in managing your household budget!</p>
                </div>
                <div class="col-lg-4 mb-3 order-lg-2 order-md-1 order-sm-1 order-1 animated fadeInRight">
                    <img src="{{ asset('storage/images/report_design.png') }}" alt="Report Image" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
@endsection