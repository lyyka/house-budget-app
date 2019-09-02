<div class="rounded shadow-sm p-4 border">
    <h4>Expenses By Category</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        <label for="expeneses_by_category_households_dropdown" class="mb-0">Household:</label>
        <select id="expeneses_by_category_households_dropdown" class="pr-2 border rounded">
            @foreach ($households as $household)
                <option value="{{ $household->id }}">{{ $household->name }}</option>
            @endforeach
        </select>
        <hr />
        <canvas class="d-block" id="categories_chart"></canvas>
    @endif
</div>