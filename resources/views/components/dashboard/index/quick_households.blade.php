<div class="rounded shadow-sm p-4 border">
    <h4>Households</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        @foreach($quick_hoseholds as $household)
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
                            <td>{{ $household->name }}</td>
                            <td>{{ count($household->members) + 1 }}</td>
                            <td>{{ $household->currency->currency_short }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endif
    <hr />
    <a href="/households/create" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
        <i class="fas fa-plus"></i> Add Household
    </a>
</div>