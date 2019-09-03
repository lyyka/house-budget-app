<div class="rounded shadow-sm p-4 border">
    <h4>Current Week Report</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        <label for="custom_range_households_dropdown">Household:</label>
        <select id="custom_range_households_dropdown" class="pr-2 border rounded">
            @foreach ($households as $household)
                <option value="{{ $household->id }}">{{ $household->name }}</option>
            @endforeach
        </select>
        <canvas class="d-block" id="custom_range_chart"></canvas>
    @endif
</div>