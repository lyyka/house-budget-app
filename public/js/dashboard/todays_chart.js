$(document).ready(docReady);

function docReady(e){
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
                    labels: data.labels,
                    values: data.values
                };
                initTodayChart(ajax_data);
            }
        });
    }
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
                backgroundColor: 'rgb(99, 255, 169)',
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