$(document).ready(docReady);

function docReady(e){
    monthlyDropdownChange();
    $("#monthly_households_dropdown").on('change', monthlyDropdownChange);
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
            console.log(data);
            
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