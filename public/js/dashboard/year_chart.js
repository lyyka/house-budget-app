$(document).ready(docReady);
let year_chart;
let current_year;
let global_household_id;

function docReady(e){
    monthlyDropdownChange();
    $("#monthly_households_dropdown").on('change', monthlyDropdownChange);
    $("#yearly_chart_prev_year").on('click', prevYear);
    $("#yearly_chart_next_year").on('click', nextYear);
    $("#refresh_yearly_chart").on('click', refreshYearlyChart);
}

function monthlyDropdownChange(){
    if(year_chart != undefined){
        year_chart.destroy();
    }
    const household_id = $("#monthly_households_dropdown").val();
    fetchMonthlyData(household_id, (new Date()).getFullYear());
}

function fetchMonthlyData(household_id, year){
    if(household_id > 0){
        global_household_id = household_id;
        const req = $.ajax({
            type: "GET",
            url: '/charts/' + household_id + '/' + year + '/monthly_data',
            async: true,
            cache: false,
        });

        req.done(function(data){
            if(data.success){
                const response = data.expenses;
                const labels = [];
                const values = [];
                response.forEach(expense => {
                    labels.push(numberToMonthString(expense.month));
                    values.push(expense.total);
                });

                current_year = year;
                $("#current_year_for_yearly_chart").text(current_year);
                if(current_year != (new Date()).getFullYear()){
                    $("#refresh_yearly_chart").removeClass('d-none');
                    $("#refresh_yearly_chart").addClass('d-inline');
                }
                else{
                    $("#refresh_yearly_chart").removeClass('d-inline');
                    $("#refresh_yearly_chart").addClass('d-none');
                }

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

function prevYear(e){
    if(current_year - 1 > 0){
        fetchMonthlyData(global_household_id, current_year - 1);
    }
}

function nextYear(e){
    if(current_year + 1 <= (new Date()).getFullYear()){
        fetchMonthlyData(global_household_id, current_year + 1);
    }
}

function refreshYearlyChart(e){
    fetchMonthlyData(global_household_id, (new Date()).getFullYear());
}