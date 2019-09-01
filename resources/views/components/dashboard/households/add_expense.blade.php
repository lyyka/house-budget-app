<div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Expense</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/expenses" method="POST">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="household_id" value = {{ $household->id }} />
                <label for="name" class="d-block">Expense title:</label>
                <input id="name" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('name') is-invalid @enderror" name="name" required autofocus placeholder="Describe the expense" value = "{{ old('name') }}" />
                @error('name')
                    <label class = "d-block text-danger">{{ $message }}</label>
                @enderror
        
                <label for="amount" class="d-block">Amount:</label>
                <input id="amount" type="number" min="1" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('amount') is-invalid @enderror" name="amount" required autofocus placeholder="How much did you spend?" value = "{{ old('amount') }}" />
                @error('amount')
                    <label class = "d-block text-danger">{{ $message }}</label>
                @enderror
        
                <label for="category" class="d-block">Category:</label>
                <input type="hidden" name="category_id" id="category" />
                <div class="position-relative">
                    <div class="w-100 mb-4 rounded shadow-sm border py-2 px-3" id="open_categories_dropdown">
                        <div id="categories_dropdown_text" class="d-inline-block">
                            Select expense category
                        </div>
                        <p class="text-right mb-0 float-right">
                            <i class="fas fa-chevron-circle-down"></i>
                        </p>
                    </div>
                    <div class="position-absolute w-100 bg-white border shadow-sm p-3" id="categories_dropdown">
                        @foreach ($expense_categories as $cat)
                            <div class="mb-3 category_item">
                                <div class="category_color_circle rounded-circle d-inline-block" style="background-color: #{{ $cat->hex_color }}"></div>
                                <p class="mb-0 d-inline-block">{{ $cat->name }}</p>
                                <p class="mb-0 d-none category_id">{{ $cat->id }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('category_id')
                    <label class = "d-block text-danger">{{ $message }}</label>
                @enderror
        
                
            </div>
            <div class="modal-footer">
                <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
                <button type = "submit" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
                    Add Expense
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