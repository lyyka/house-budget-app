@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h3>Browse Households</h3>
        <a href="/households/create" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
            <i class="fas fa-plus"></i> Add Household
        </a>
        <hr />
        @if (count($households) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Members</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($households as $household)
                        <tr>
                            <th scope="row">{{ $household->id }}</th>
                            <td>{{ $household->name }}</td>
                            <td>{{ count($household->members) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-muted">
                No households, add some.
            </p>
        @endif
    </div>
@endsection