<div class="modal fade" id="exportDataToXlsxModal" tabindex="-1" role="dialog" aria-labelledby="exportDataToXlsxModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exportDataToXlsxModalTitle">
                Export Data To Excel
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @if (Auth::user()->hasVerifiedEmail())
                <div class="row">
                    <div class="col-lg-6 mb-0 mb-lg-0 mb-md-4 mb-sm-4">
                        <label for="start_date">
                            Select starting date
                        </label>
                        <input type="date" name="start_date" id="start_date" class="rounded shadow-sm border p-2 w-100" />
                    </div>
                    <div class="col-lg-6">
                        <label for="end_date">
                            Select ending date
                        </label>
                        <input type="date" max="{{ date("Y-m-d") }}" name="end_date" id="end_date" class="rounded shadow-sm border p-2 w-100" />
                    </div>
                </div>
                <hr />
                <div class="mb-4">
                    <label>Select categories to export: </label>
                    <div class="row">
                        <div class="col-lg-6">
                            @for ($i = 0; $i < count($expense_categories) / 2; $i++)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="export_categories[]" id="export_categories_{{ $expense_categories[$i]->id }}" value="{{ $expense_categories[$i]->name }}" />
                                    <label class="custom-control-label" for="export_categories_{{ $expense_categories[$i]->id }}">
                                        {{ $expense_categories[$i]->name }}
                                    </label>
                                    <br />
                                </div>
                            @endfor
                        </div>
                        <div class="col-lg-6">
                            @for ($i = count($expense_categories) / 2; $i < count($expense_categories); $i++)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="export_categories[]" id="export_categories_{{ $expense_categories[$i]->id }}" value="{{ $expense_categories[$i]->name }}" />
                                    <label class="custom-control-label" for="export_categories_{{ $expense_categories[$i]->id }}">
                                        {{ $expense_categories[$i]->name }}
                                    </label>
                                    <br />
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-lg-6 mb-0 mb-lg-0 mb-md-4 mb-sm-4">
                        <label for="start_date">
                            Min. Amount
                        </label>
                        <input type="number" min="0" name="min_amount" id="min_amount" class="rounded shadow-sm border p-2 w-100" placeholder="Min. Expense Amount" />
                        <label class="text-muted">{{ $household->currency->currency_short }}</label>
                    </div>
                    <div class="col-lg-6">
                        <label for="max_amount">
                            Max. Amount
                        </label>
                        <input type="number" min="1" name="max_amount" id="max_amount" class="rounded shadow-sm border p-2 w-100" placeholder="Max. Expense Amount" />
                        <label class="text-muted">{{ $household->currency->currency_short }}</label>
                    </div>
                </div>
                <hr />
                <button type="button" id="start_export" class="border rounded shadow-sm py-1 px-3 bg-info text-white">
                    <i class="fas fa-file-export"></i>
                    <span id="start_export_text">
                        Start Export
                    </span>
                </button>
                <a href ="javascript:void(0)" target="_blank" id="export_download_link" class="border rounded shadow-sm py-1 px-3 bg-success text-white">
                    <i class="fas fa-file-download"></i>
                    Download Exported File
                </a>
            @else
                <p class="text-center text-muted">
                    Please verify your email address to be able to import expenses from Excel spreadsheet
                </p>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>