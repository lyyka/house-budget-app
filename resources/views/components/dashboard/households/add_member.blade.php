<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/members" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="household_id" value = {{ $household->id }} />
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="first_name" class="d-block">First Name:</label>
                            <input id="first_name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('first_name') is-invalid @enderror" name="first_name" required autofocus placeholder="First Name" value = "{{ old('first_name') }}" />
                            @error('first_name')
                                <label class = "d-block text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label for="last_name" class="d-block">Last Name:</label>
                            <input id="last_name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('last_name') is-invalid @enderror" name="last_name" required autofocus placeholder="Last Name" value = "{{ old('last_name') }}" />
                            @error('last_name')
                                <label class = "d-block text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
            
                    <label for="additional_income" class="d-block">Additional Income (optional):</label>
                    <input id="additional_income" type="number" min="0" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('additional_income') is-invalid @enderror" name="additional_income" autofocus placeholder="How much does the member make?" value = "{{ old('additional_income') }}" />
                    @error('additional_income')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
                    <button type = "submit" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
                        Add a Member
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>
    {{-- <div class="rounded shadow-sm border p-4">
        <h3>Add Expense</h3>
        <hr />
        
    </div> --}}