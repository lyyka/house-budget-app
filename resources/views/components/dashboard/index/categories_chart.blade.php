<div class="rounded shadow-sm p-4 border bg-white">
    <h4>Expenses By Category</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        @if (Auth::user()->hasVerifiedEmail())
            <label for="expeneses_by_category_households_dropdown" class="mb-0">Household:</label>
            <select id="expeneses_by_category_households_dropdown" class="pr-2 border rounded">
                @foreach ($households as $household)
                    <option value="{{ $household->id }}">{{ $household->name }}</option>
                @endforeach
            </select>
            <hr />
            <canvas class="d-block" id="categories_chart"></canvas>
        @else
            <p class="text-center text-muted">
                Please verify your email to access this quick chart
            </p>
        @endif
    @endif
</div>