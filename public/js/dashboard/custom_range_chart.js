$(document).ready(docReady);
let weekdays_chart;
let start_date;
let end_date;

function docReady(e){
    customRangeDropdownChanged();
    $("#custom_range_households_dropdown").on('change', customRangeDropdownChanged);
    $("#custom_range_start").on("change", startDateChange);
    $("#custom_range_end").on("change", endDateChange);
}

function startDateChange(e){
    start_date = $(this).val();
    fetchCustomRangeData($("#household_id").val());
}

function endDateChange(e){
    end_date = $(this).val();
    fetchCustomRangeData($("#household_id").val());
}


function customRangeDropdownChanged(){
    
    const household_id = $("#custom_range_households_dropdown").val();
    fetchCustomRangeData(household_id);
}

function fetchCustomRangeData(household_id){
    if(household_id > 0){
        let url = '/charts/' + household_id + '/custom_range';
        let has_start = false;
        if(start_date != undefined){
            has_start = true;
            url += '?start=' + start_date;
        }
        if(end_date != undefined){
            let leading_char = has_start ? '&' : '?';
            url += leading_char + 'end=' + end_date;
        }

        const req = $.ajax({
            type: "GET",
            url: url,
            async: true,
            cache: false,
        });

        req.done(function(data){
            if(data.success){
                const expenses = data.expenses;
                const days = [];
                const totals = [];

                expenses.forEach(expense => {
                    const date_obj = new Date(expense.date);
                    days.push((date_obj.getDay()+1) + '/' + (date_obj.getMonth()+1) + '/' + date_obj.getFullYear());
                    totals.push(expense.total);
                });
            
                const ajax_data = {
                    labels: days,
                    values: totals
                };
                initCustomRangeChart(ajax_data);
            }
        }); 

        req.fail(function(data){
            console.log(data);
            
        })
    }
}

function initCustomRangeChart(ajax_data){
    // init this month chart
    const ctx = document.getElementById('custom_range_chart').getContext('2d');
    if(weekdays_chart != undefined){
        weekdays_chart.destroy();
    }
    weekdays_chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',
    
        // The data for our dataset
        data: {
            labels: ajax_data.labels,
            datasets: [{
                label: 'Money spent by day',
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