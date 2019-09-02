<div class="rounded shadow-sm border p-4">
    <h3>Expense List by Month</h3>
    <div class="text-right">
        <div class="text-dark float-left">
            <a href="/households/{{ $household->id }}/expenses/prev_month" id="expense_table_prev" class="cursor-pointer text-dark">
                <i class="fas fa-angle-left"></i>
            </a>
            {{ $expense_list_current_date['month'] }}, {{ $expense_list_current_date['year'] }}
            <a href="/households/{{ $household->id }}/expenses/next_month" id="expense_table_next" class="cursor-pointer text-dark">
                <i class="fas fa-angle-right"></i>
            </a>
            @if (date('M') != $expense_list_current_date['month'] || date("Y") != $expense_list_current_date['year'])
                <a href="/households/expenses/reset_expenses_list" class="cursor-pointer text-dark">
                    <i class="fas fa-sync-alt"></i>
                </a>
            @endif
        </div>
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
                    <tr class="cursor-pointer expense_row" data-expense-id = "{{ $expense->id }}">
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
        {{ $expenses->links("vendor.pagination.bootstrap-4") }}
        <hr />
        <p>
            <strong>Total: </strong> @money($total_expenses * 100, $household->currency->currency_short)
        </p>
    @else
        <p class="text-center text-muted">
            No expense data
        </p>
    @endif
</div>