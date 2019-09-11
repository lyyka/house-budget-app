<div class="rounded shadow-sm p-4 border bg-white">
    <h4>Today</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        <label for="daily_chart_households_dropdown">Household:</label>
        <select id="daily_chart_households_dropdown" class="pr-2 border rounded">
            @foreach ($households as $household)
                <option value="{{ $household->id }}">{{ $household->name }}</option>
            @endforeach
        </select>
        <canvas class="d-block" id="daily_chart_by_hours"></canvas>
    @endif
</div>