$(document).ready(docReady);
let daily_chart;
let daily_chart_custom_day;

function docReady(e){
    dailyDropdownChange();
    $("#daily_chart_households_dropdown").on('change', dailyDropdownChange);
    $("#daily_chart_date_dropdown").on('change', dateChanged);
}

function dateChanged(e){
    daily_chart_custom_day = $(this).val();
    fetchDailyData($("#household_id").val());
}

function dailyDropdownChange(){
    const household_id = $("#daily_chart_households_dropdown").val();
    fetchDailyData(household_id);
}

function fetchDailyData(household_id){
    if(household_id > 0){
        let url = '/charts/' + household_id + '/daily_data_by_hour';
        if(daily_chart_custom_day != undefined){
            url += '/' + daily_chart_custom_day;
        }
        const req = $.ajax({
            type: "GET",
            url: url,
            async: true,
            cache: false,
        });

        req.done(function(data){
            if(data.success){
                const response = data.expenses;
                const labels = [];
                const values = [];
                response.forEach(expense => {
                    labels.push(expense.hour);
                    values.push(expense.total);
                });
            
                const ajax_data = {
                    labels: labels,
                    values: values
                };
                initTodayChart(ajax_data);
            }
        });
    }
}

function initTodayChart(ajax_data){
    // init this month chart
    const ctx = document.getElementById('daily_chart_by_hours').getContext('2d');
    if(daily_chart != undefined){
        daily_chart.destroy();
    }
    daily_chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
    
        // The data for our dataset
        data: {
            labels: ajax_data.labels,
            datasets: [{
                label: 'Money spent by hour',
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