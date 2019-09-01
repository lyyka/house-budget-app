<div class="rounded shadow-sm border p-4">
    <h3>Balance</h3>
    <hr />
    <p class="h1 {{ $household->current_state <=  $household->expected_monthly_savings || $household->current_state <= 0 ? "text-danger" : "text-success"}}">
        @money($household->current_state * 100, $household->currency->currency_short)
    </p>
    <hr />
    <div class="row">
        <div class="col-lg-6 mb-2">
            <p class="mb-1">
                Monthly Income
            </p>
            @money($monthly_income * 100, $household->currency->currency_short)
        </div>
        <div class="col-lg-6 mb-2">
            <p class="mb-1">
                Expected Savings
            </p>
            @money($household->expected_monthly_savings * 100, $household->currency->currency_short)
        </div>
    </div>
    <hr />
    <p class="mb-1 text-muted">
        Budget will be reset on {{ date('d/m/Y', strtotime('+1 month', strtotime(date("Y") . '-' . date('m') . '-' . $household->budget_reset_day))) }}
    </p>
</div>