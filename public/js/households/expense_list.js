$(document).ready(docReady);

function docReady(e){
    $(".expense_row").click(loadExpense);
}

function loadExpense(e){
    const id = $(this).attr("data-expense-id");
    fetchExpense(id);
}

function fetchExpense(id){
    if(id > 0){
        const req = $.ajax({
            type: "GET",
            url: '/expenses/' + id + '/getData',
            async: true,
            cache: false,
        });

        req.done(function(data){
            const success = data.success;

            if(success){
                const expense = data.expense_data;
                const category = data.expense_category;
                console.log(category);
                
                loadUpModal(expense, category);
            }
        });
    }
}

function loadUpModal(expense, category){
    const name = expense.name;
    const amount = expense.amount;
    const made_at = expense.expense_made_at;
    const category_name = category.name;
    const category_color = category.hex_color;

    $("#expenseShowModalTitle").text(name);
    $("#exp_amount").text(amount.toFixed(2));
    $("#exp_made_at").text(made_at);
    $("#exp_category_color_circle").css('background-color', "#" + category_color);
    $("#exp_category_name").text(category_name);

    $("#expenseShowModal").modal('show');
}