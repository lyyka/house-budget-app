$(document).ready(docReady);

function docReady(e){
    monthlyDropdownChange();
    $("#monthly_households_dropdown").on('change', monthlyDropdownChange);

    todayDropdownChange();
    $("#today_households_dropdown").on('change', todayDropdownChange);
}

function todayDropdownChange(){
    const household_id = $("#today_households_dropdown").val();
    if(household_id > 0){
        const req = $.ajax({
            type: "GET",
            url: '/households/' + household_id + '/today_data',
            async: true,
            cache: false,
        });

        req.done(function(data){
            if(data.success){
                const ajax_data = {
                    labels: ['0' , '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'],
                    values: data.values
                };
                initTodayChart(ajax_data);
            }
        });
    }
}

function monthlyDropdownChange(){
    const household_id = $("#monthly_households_dropdown").val();
    if(household_id > 0){
        const req = $.ajax({
            type: "GET",
            url: '/households/' + household_id + '/monthly_data',
            async: true,
            cache: false,
        });

        req.done(function(data){
            if(data.success){
                const ajax_data = {
                    labels: data.labels,
                    values: data.values
                };
                initMonthlyChart(ajax_data);
            }
        });
    }
}

function initMonthlyChart(ajax_data){
    // init this month chart
    const ctx = document.getElementById('current_month_chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ajax_data.labels,
            datasets: [{
                label: 'Money spent by month',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: ajax_data.values
            }]
        },

        // Configuration options go here
        options: {}
    });
}

function initTodayChart(ajax_data){
    // init this month chart
    const ctx = document.getElementById('today_chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
    
        // The data for our dataset
        data: {
            labels: ajax_data.labels,
            datasets: [{
                label: 'Money spent by hour',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: ajax_data.values
            }]
        },
    
        // Configuration options go here
        options: {}
    });
}