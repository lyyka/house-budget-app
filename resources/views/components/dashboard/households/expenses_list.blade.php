<div class="rounded shadow-sm border p-4">
    <h3>Expenses</h3>
    <div class="text-right">
        <button type="button" class="mb-2 px-3 py-1 bg-info text-white rounded shadow-sm border" data-toggle="modal" data-target="#addExpenseModal">
            Add Expense
        </button>
    </div>
    @if (count($expenses) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col" class="d-none d-md-table-cell">Category</th>
                    <th scope="col" class="d-none d-lg-table-cell">Made At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <th scope="row">{{ $expense->name }}</th>
                        <td>
                            @money($expense->amount * 100, $household->currency->currency_short)
                        </td>
                        <td class="d-none d-md-table-cell">
                            <div class="rounded-circle d-inline-block" style="width:15px; height:15px; background-color: #{{ $expense->category->hex_color }}"></div>
                            {{ $expense->category->name }}
                        </td>
                        <td class="d-none d-lg-table-cell">{{ $expense->expense_made_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center text-muted">
            No expense data
        </p>
    @endif
</div>