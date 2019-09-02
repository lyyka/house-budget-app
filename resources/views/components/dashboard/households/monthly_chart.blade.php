<div class="rounded shadow-sm border p-4">
    <h3>Yearly Report</h3>
    <div class="text-darkt">
        <span id="yearly_chart_prev_year" class="cursor-pointer text-dark">
            <i class="fas fa-angle-left"></i>
        </span>
        <span id="current_year_for_yearly_chart"></span>
        <span id="yearly_chart_next_year" class="cursor-pointer text-dark">
            <i class="fas fa-angle-right"></i>
        </span>
        <span id = "refresh_yearly_chart" class="cursor-pointer text-dark d-none">
            <i class="fas fa-sync-alt"></i>
        </span>
    </div>
    <hr />
    <canvas id = "this_year_chart"></canvas>
</div>