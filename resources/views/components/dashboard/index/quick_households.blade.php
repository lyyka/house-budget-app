<div class="rounded shadow-sm p-4 border">
    <h4>Households</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Members</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quick_hoseholds as $household)
                    <tr>
                        <th scope="row">{{ $household->id }}</th>
                        <td>
                            <a href="/households/{{ $household->id }}" class="text-info">
                                {{ $household->name }}
                                <i class="fas fa-link"></i>
                            </a>
                        </td>
                        <td>{{ count($household->members) + 1 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <hr />
    <a href="/households/create" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
        <i class="fas fa-plus"></i> Add Household
    </a>
</div>