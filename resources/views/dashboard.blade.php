@extends('layouts.dashboard')

@section('content')

{{-- dashboard --}}
<div class="container">
    <div class="row">
        <div class="col-lg-6 mb-5">
            <div class="rounded shadow-sm p-4 border">
                <h4>Households</h4>
                <hr />
                @if (count($households) == 0)
                    <p class="text-center text-muted">
                        No households data
                    </p>
                @else
                    @foreach($paginated_households as $household)
                        <p>
                            {{ $household->name  }}
                        </p>
                        <hr />
                    @endforeach
                @endif
                <hr />
                <a href="/households/create" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
                    <i class="fas fa-plus"></i> Add Household
                </a>
            </div>
        </div>
        <div class="col-lg-6 mb-5">
            <div class="rounded shadow-sm p-4 border">
                <h4>Today</h4>
                <hr />
                @if (count($households) == 0)
                    <p class="text-center text-muted">
                        No households data
                    </p>
                @else
                    <select id="households_dropdown" class="py-1 px-3 rounded shadow-sm border">
                        @foreach ($households as $household)
                            <option value="{{ $household->id }}">{{ $household->name }}</option>
                        @endforeach
                    </select>
                    <canvas class="d-block" id="today_chart"></canvas>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-5">
            <div class="rounded shadow-sm p-4 border">
                <h4>This Month</h4>
                <hr />
                @if (count($households) == 0)
                    <p class="text-center text-muted">
                        No households data
                    </p>
                @else
                    <select id="households_dropdown" class="py-1 px-3 rounded shadow-sm border">
                        @foreach ($households as $household)
                            <option value="{{ $household->id }}">{{ $household->name }}</option>
                        @endforeach
                    </select>
                    <canvas class="d-block" id="current_month_chart"></canvas>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
