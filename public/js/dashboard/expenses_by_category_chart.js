$(document).ready(docReady);

function docReady(e){
    expensesByCategoryDropdownChange();
    $("#expeneses_by_category_households_dropdown").on('change', expensesByCategoryDropdownChange);
}

function expensesByCategoryDropdownChange(){
    const household_id = $("#expeneses_by_category_households_dropdown").val();
    fetchExpensesByCategoryData(household_id);
}

function fetchExpensesByCategoryData(household_id){
    if(household_id > 0){
        const req = $.ajax({
            type: "GET",
            url: '/households/' + household_id + '/expenses_by_category',
            async: true,
            cache: false,
        });

        req.done(function(data){
            console.log(data);
            
            const expenses = data.expenses;
            const categories = [];
            const category_colors = [];
            const totals = [];

            expenses.forEach(expense => {
                categories.push(expense.category_name);
                category_colors.push("#" + expense.category_color);
                totals.push(expense.total);
            });
            
            if(data.success){
                const ajax_data = {
                    labels: categories,
                    colors: category_colors,
                    values: totals
                };
                initChartByCategory(ajax_data);
            }
        });
    }
}

function initChartByCategory(ajax_data){
    // init this month chart
    const ctx = document.getElementById('categories_chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
    
        // The data for our dataset
        data: {
            labels: ajax_data.labels,
            datasets: [{
                label: 'Money spent by category',
                backgroundColor: ajax_data.colors,
                // borderColor: 'rgb(79, 235, 149)',
                data: ajax_data.values
            }]
        },
    
        // Configuration options go here
        options: {
            legend: {
                display: false
            },
            animation: {
                duration: 2000
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                barPercentage: 0.7,
            }
        }
    });
}