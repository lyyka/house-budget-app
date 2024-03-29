<div class="modal fade" id="editHousehold" tabindex="-1" role="dialog" aria-labelledby="editHouseholdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHouseholdTitle">Edit Household</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/households/{{ $household->id }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="name" class="d-block">Household name: <span class="text-info">*</span></label>
                            <input id="name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $household->name) }}" required placeholder="Use a name to recognize this household" />
                            @error('name')
                                <label class = "d-block text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label for="currency" class="d-block">Default currency: <span class="text-info">*</span></label>
                            <select name="currency" id="currency" class="mb-4 w-100 rounded shadow-sm border py-2 px-3">
                                @foreach ($currencies as $curr)
                                    <option {{ $curr->id == $household->currency_id ? "selected" : "" }} value="{{ $curr->id }}">{{ $curr->currency_name }} ({{ $curr->currency_short }})</option>
                                @endforeach
                            </select>
                            @error('currency')
                                <label class = "d-block text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <label for="monthly_income" class="d-block">Monthly Income: <span class="text-info">*</span></label>
                            <input id="monthly_income" type="number" class="w-100 rounded shadow-sm border py-2 px-3 @error('monthly_income') is-invalid @enderror" name="monthly_income" value="{{ old('monthly_income', $household->monthly_income) }}" required placeholder="Income" />
                            <label class="text-muted">
                                *Your income. You can add other peoples income by adding a member.
                            </label>
                            @error('monthly_income')
                                <label class = "d-block text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label for="expected_monthly_savings" class="d-block">Expected Monthly Savings:</label>
                            <input id="expected_monthly_savings" min="0" type="number" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('expected_monthly_savings') is-invalid @enderror" name="expected_monthly_savings" value="{{ old('expected_monthly_savings', $household->expected_monthly_savings) }}" placeholder="How much do you expect to save?" />
                            @error('expected_monthly_savings')
                                <label class = "d-block text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="budget_reset_day" class="d-block">When is the budget reset? <span class="text-info">*</span></label>
                            <input id="budget_reset_day" type="number" min="1" max="31" class="w-100 rounded shadow-sm border py-2 px-3 @error('budget_reset_day') is-invalid @enderror" name="budget_reset_day" value="{{ old('budget_reset_day', $household->budget_reset_day) }}" required placeholder="When will the budget be reset to total monthly income?" />
                            <label class="d-block text-muted">Day of each month</label>
                            @error('budget_reset_day')
                                <label class = "d-block text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <hr />
                    <h5>Other options:</h5>
                    @php
                        $opts = json_decode($household->options);
                    @endphp
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" {{ $opts != null && $opts->allow_low_balance_emails != null && $opts->allow_low_balance_emails ? 'checked' : '' }} name="allow_low_balance_emails" id="allow_low_balance_emails">
                        <label class="custom-control-label" for="allow_low_balance_emails">Notify me via email when balance of this household drops below 0 or below expected monthly savings</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
                    <button type = "submit" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>