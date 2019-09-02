$(document).ready(docReady);
let year_chart;

function docReady(e){
    monthlyDropdownChange();
    $("#monthly_households_dropdown").on('change', monthlyDropdownChange);
}

function monthlyDropdownChange(){
    if(year_chart != undefined){
        year_chart.destroy();
    }
    const household_id = $("#monthly_households_dropdown").val();
    fetchMonthlyData(household_id);
}

function fetchMonthlyData(household_id){
    if(household_id > 0){
        const req = $.ajax({
            type: "GET",
            url: '/households/' + household_id + '/monthly_data',
            async: true,
            cache: false,
        });

        req.done(function(data){
            const response = data.expenses;
            const labels = [];
            const values = [];
            response.forEach(expense => {
                labels.push(numberToMonthString(expense.month));
                values.push(expense.total);
            });
            
            if(data.success){
                const ajax_data = {
                    labels: labels,
                    values: values
                };
                initMonthlyChart(ajax_data);
            }
        });
    }
}

function numberToMonthString(number){
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    return months[number - 1];
}

function initMonthlyChart(ajax_data){
    // init this month chart
    const ctx = document.getElementById('this_year_chart').getContext('2d');
    year_chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ajax_data.labels,
            datasets: [{
                label: 'Money spent by month',
                fill: false,
                // backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(235,79,112)',
                data: ajax_data.values
            }]
        },

        // Configuration options go here
        options: {
            legend: {
                position: 'bottom'
            },
            animation: {
                duration: 2000
            }
        }
    });
}