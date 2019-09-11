<div class="rounded shadow-sm p-4 border bg-white">
    <h4>Current Week Report</h4>
    <hr />
    @if (count($households) == 0)
        <p class="text-center text-muted">
            No households data
        </p>
    @else
        @if (Auth::user()->hasVerifiedEmail())
            <label for="custom_range_households_dropdown">Household:</label>
            <select id="custom_range_households_dropdown" class="pr-2 border rounded">
                @foreach ($households as $household)
                    <option value="{{ $household->id }}">{{ $household->name }}</option>
                @endforeach
            </select>
            <canvas class="d-block" id="custom_range_chart"></canvas>
        @else
            <p class="text-center text-muted">
                Please verify your email to access this quick chart
            </p>
        @endif
    @endif
</div>