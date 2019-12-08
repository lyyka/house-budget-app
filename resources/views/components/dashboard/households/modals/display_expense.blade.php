<div class="modal fade" id="expenseShowModal" tabindex="-1" role="dialog" aria-labelledby="expenseShowModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="expenseShowModalTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id = "expense_show_modal_body">
            <p>
                <strong>Amount:</strong>
                <span id="exp_amount"></span>
                {{ $household->currency->currency_short }}
            </p>
            <p>
                <strong>Expense Made At:</strong>
                <span id="exp_made_at"></span>
            </p>
            <strong>Category:</strong>
            <div id = "exp_category_color_circle" class="rounded-circle d-inline-block" style="width: 15px; height:15px;"></div>
            <span id="exp_category_name"></span>
            @can('delete-expense', $household)
                <hr />
                <form method="POST" id = "del_expense_form">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="px-3 py-1 bg-danger text-white rounded shadow-sm border">Delete this expense</button>
                </form>
            @endcan
        </div>
        <div class="modal-footer">
            <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>