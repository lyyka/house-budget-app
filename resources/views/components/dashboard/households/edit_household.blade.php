<div class="modal fade" id="editHousehold" tabindex="-1" role="dialog" aria-labelledby="editHouseholdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editHousehold">Edit Household</h5>
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
                        <label for="name" class="d-block">Household name:</label>
                        <input id="name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $household->name) }}" required autofocus placeholder="Use a name to recognize this household" />
                        @error('name')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="currency" class="d-block">Default currency:</label>
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
                        <label for="monthly_income" class="d-block">Monthly Income:</label>
                        <input id="monthly_income" type="number" class="w-100 rounded shadow-sm border py-2 px-3 @error('monthly_income') is-invalid @enderror" name="monthly_income" value="{{ old('monthly_income', $household->monthly_income) }}" required placeholder="Income" />
                        <label class="text-info">
                            *Enter only your income to the household. You can add other members with their income afterwards.
                        </label>
                        @error('monthly_income')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="expected_monthly_savings" class="d-block">Expected Monthly Savings (optional):</label>
                        <input id="expected_monthly_savings" min="0" type="number" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('expected_monthly_savings') is-invalid @enderror" name="expected_monthly_savings" value="{{ old('expected_monthly_savings', $household->expected_monthly_savings) }}" placeholder="How much do you expect to save?" />
                        @error('expected_monthly_savings')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="budget_reset_day" class="d-block">When is the budget reset?</label>
                        <input id="budget_reset_day" type="number" min="1" max="31" class="w-100 rounded shadow-sm border py-2 px-3 @error('budget_reset_day') is-invalid @enderror" name="budget_reset_day" value="{{ old('budget_reset_day', $household->budget_reset_day) }}" required placeholder="When will the budget be reset to total monthly income?" />
                        <label class="d-block text-info">Day of the month</label>
                        @error('budget_reset_day')
                            <label class = "d-block text-danger">{{ $message }}</label>
                        @enderror
                    </div>
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