<div class="rounded shadow-sm border p-4 bg-white">
    <h3 class="mb-0">Custom Range</h3>
    <p class="text-muted">
        Default is current week
    </p>
    <input type="date" id="custom_range_start" placeholder="Start date" class="rounded border shadow-sm" />
    <i class="fas fa-exchange-alt mx-2"></i>
    <input type="date" id="custom_range_end" max="{{ date("Y-m-d") }}" placeholder="Start date" class="rounded border shadow-sm" />
    <hr />
    <canvas id = "custom_range_chart"></canvas>
</div>