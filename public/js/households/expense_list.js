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
                loadUpModal(expense, category);
            }
        });
    }
}

function numberToMonthString(number){
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    return months[number];
}

function loadUpModal(expense, category){
    const name = expense.name;
    const amount = expense.amount;
    const made_at_date = new Date(expense.created_at);
    
    const made_at = (made_at_date.getDay() + 1) + ' ' + numberToMonthString(made_at_date.getMonth()) + ', ' + made_at_date.getFullYear() + ' at ' + made_at_date.getHours() + ':' + made_at_date.getMinutes();
    const category_name = category.name;
    const category_color = category.hex_color;

    $("#expenseShowModalTitle").text(name);
    $("#exp_amount").text(amount.toFixed(2));
    $("#exp_made_at").text(made_at);
    $("#exp_category_color_circle").css('background-color', "#" + category_color);
    $("#exp_category_name").text(category_name);
    $("#del_expense_form").attr('action', '/expenses/' + expense.id);

    $("#expenseShowModal").modal('show');
}