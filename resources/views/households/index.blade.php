@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h3>Browse Households</h3>
        <a href="/households/create" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
            <i class="fas fa-plus"></i> Add Household
        </a>
        <hr />
        {{-- my households --}}
        <h5>My Households</h5>
        @if (count($households) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Members</th>
                        <th scope="col">Currency</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($households as $household)
                        <tr>
                            <th scope="row">{{ $household->id }}</th>
                            <td>
                                <a href="/households/{{ $household->id }}" class="text-info">
                                    {{ $household->name }}
                                    <i class="fas fa-link"></i>
                                </a>
                            </td>
                            <td>{{ count($household->members) + 1 }}</td>
                            <td>{{ $household->currency->currency_short }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $households->links("vendor.pagination.bootstrap-4") }}
        @else
            <p class="text-center text-muted">
                No households, add some.
            </p>
        @endif

        {{-- shared households --}}
        <h5>Shared with me</h5>
        @if (count($shared_households) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Members</th>
                        <th scope="col">Currency</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shared_households as $share_link)
                        <tr>
                            <th scope="row">{{ $share_link->household->id }}</th>
                            <td>
                                <a href="/households/{{ $share_link->household->id }}" class="text-info">
                                    {{ $share_link->household->name }}
                                    <i class="fas fa-link"></i>
                                </a>
                            </td>
                            <td>{{ count($share_link->household->members) + 1 }}</td>
                            <td>{{ $share_link->household->currency->currency_short }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $households->links("vendor.pagination.bootstrap-4") }}
        @else
            <p class="text-center text-muted">
                No households shared with you
            </p>
        @endif
    </div>
@endsection