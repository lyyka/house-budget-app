<div class="rounded shadow-sm border p-4 bg-white">
    <h3><i class="fas fa-clipboard-list"></i> Expense List by Month</h3>
    <div class="text-right">
        @can('view-expense', $household)
            <div class="text-dark float-left">
                <a href="/expenses/{{ $household->id }}/prev_month" id="expense_table_prev" class="cursor-pointer text-dark">
                    <i class="fas fa-angle-left"></i>
                </a>
                @php
                    $formatted_current_month = (DateTime::createFromFormat('!m', $expense_list_current_date['month']))->format("M");
                @endphp
                {{ $formatted_current_month }}, {{ $expense_list_current_date['year'] }}
                <a href="/expenses/{{ $household->id }}/next_month" id="expense_table_next" class="cursor-pointer text-dark">
                    <i class="fas fa-angle-right"></i>
                </a>
                @if (date('M') != $formatted_current_month || date("Y") != $expense_list_current_date['year'])
                    <a href="/expenses/reset_expenses_list" class="cursor-pointer text-dark">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                @endif
            </div>
        @endcan
        
        @can('add-expense', $household)
            <button type="button" class="mb-2 px-3 py-1 bg-info text-white rounded shadow-sm border" data-toggle="modal" data-target="#addExpenseModal">
                Add Expense
            </button>
        @endcan
    </div>
    @can('view-expense', $household)
            @if (count($expenses) > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                            {{-- <th scope="col" class="d-none d-md-table-cell">Category</th> --}}
                            <th scope="col">Category</th>
                            {{-- <th scope="col" class="d-none d-lg-table-cell">Made At</th> --}}
                            <th scope="col">Made At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr class="cursor-pointer expense_row" data-expense-id = "{{ $expense->id }}">
                                <th scope="row">{{ $expense->name }}</th>
                                <td>
                                    {{ $household->currency->char }} @convertMoney($expense->amount)
                                </td>
                                {{-- <td class="d-none d-md-table-cell"> --}}
                                <td>
                                    <div class="rounded-circle d-inline-block" style="width:15px; height:15px; background-color: #{{ $expense->category->hex_color }}"></div>
                                    {{ $expense->category->name }}
                                </td>
                                {{-- <td class="d-none d-lg-table-cell">{{ date("d M, Y H:i", strtotime($expense->created_at)) }}</td> --}}
                                <td>{{ date("d M, Y H:i", strtotime($expense->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $expenses->links("vendor.pagination.bootstrap-4") }}
            <hr />
            <p>
                <strong>Total: </strong> {{ $household->currency->char }} @convertMoney($total_expenses)
            </p>
        @else
            <p class="text-center text-muted">
                No expense data
            </p>
        @endif
    @endcan
</div>