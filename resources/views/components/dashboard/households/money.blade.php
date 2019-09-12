<div class="rounded shadow-sm border p-4 bg-white">
    @can('view-household-balance', $household)
        <h3><i class="fas fa-coins"></i> Balance</h3>
        <hr />
        <p class="h1 {{ $household->current_state <=  $household->expected_monthly_savings || $household->current_state <= 0 ? "text-danger" : "text-success"}}">
            {{ $household->currency->char }} @convertMoney($household->current_state)
        </p>
        <hr />
        <div class="row">
            <div class="col-lg-6 mb-2">
                <p class="mb-1">
                    <strong>Monthly Income</strong>
                </p>
                {{ $household->currency->char }} @convertMoney($monthly_income)
            </div>
            <div class="col-lg-6 mb-2">
                <p class="mb-1">
                    <strong>Expected Savings</strong>
                </p>
                {{ $household->currency->char }} @convertMoney($household->expected_monthly_savings)
            </div>
        </div>
        <hr />
        <p class="mb-1 text-muted">
            Budget will be reset on {{ date('d/m/Y', strtotime('+1 month', strtotime(date("Y") . '-' . date('m') . '-' . $household->budget_reset_day))) }}
        </p>
    @endcan
    @can('view-expense', $household)
        <hr />
        <button type="button" class="mb-2 py-1 px-3 bg-info text-white rounded shadow-sm border" data-toggle="modal" data-target="#exportDataToXlsxModal">
            <i class="fas fa-file-export"></i>
            Export to Excel
        </button>
        <button type="button" class="mb-2 py-1 px-3 bg-success text-white rounded shadow-sm border" data-toggle="modal" data-target="#importDataFromXlsxModal">
            <i class="fas fa-file-upload"></i>
            Import from Excel
        </button>
    @endcan
</div>