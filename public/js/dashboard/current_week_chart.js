$(document).ready(docReady);
let weekdays_chart;

function docReady(e){
    currentWeekDropdownChange();
    $("#current_week_households_dropdown").on('change', currentWeekDropdownChange);
}

function currentWeekDropdownChange(){
    if(weekdays_chart != undefined){
        weekdays_chart.destroy();
    }
    const household_id = $("#current_week_households_dropdown").val();
    fetchCurrentWeeksData(household_id);
}

function fetchCurrentWeeksData(household_id){
    if(household_id > 0){
        const req = $.ajax({
            type: "GET",
            url: '/households/' + household_id + '/current_week_data',
            async: true,
            cache: false,
        });

        req.done(function(data){
            if(data.success){
                const expenses = data.expenses;
                const days = [];
                const totals = [];

                expenses.forEach(expense => {
                    days.push(expense.dayname);
                    totals.push(expense.total);
                });
            
                const ajax_data = {
                    labels: days,
                    values: totals
                };
                initThisWeekChart(ajax_data);
            }
        });
    }
}

function initThisWeekChart(ajax_data){
    // init this month chart
    const ctx = document.getElementById('current_week_chart').getContext('2d');
    weekdays_chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
    
        // The data for our dataset
        data: {
            labels: ajax_data.labels,
            datasets: [{
                label: 'Money spent by day this week',
                fill: false,
                // backgroundColor: 'rgb(99, 255, 169)',
                borderColor: 'rgb(79, 235, 149)',
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