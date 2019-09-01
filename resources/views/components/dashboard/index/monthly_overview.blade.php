<div class="rounded shadow-sm p-4 border">
    <h4>Monthly Overview</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        <label for="monthly_households_dropdown">Household:</label>
        <select id="monthly_households_dropdown" class="pr-2 border rounded">
            @foreach ($households as $household)
                <option value="{{ $household->id }}">{{ $household->name }}</option>
            @endforeach
        </select>
        <canvas class="d-block" id="current_month_chart"></canvas>
    @endif
</div>