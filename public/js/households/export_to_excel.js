$(document).ready(docReady);

function docReady(e){
    $("#start_export").click(getFile);
    $("#exportDataToXlsxModal").on('show.bs.modal', function(){
        $("#start_export").show();
        $("#export_download_link").hide();
    });
    $("#exportDataToXlsxModal").on('hide.bs.modal', function(){
        $("#start_export").show();
        $("#export_download_link").hide();
    });
}

function getFile(e){
    const btn = $(this);
    const btn_text = btn.find("#start_export_text");
    btn_text.html('Exporting <i class="fas fa-spinner"></i>');
    btn.unbind('click');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const selected_categories = [];
    $('input:checkbox[name=export_categories\\[\\]]:checked').each(function(){
        selected_categories.push($(this).val());
    });
    
    const req = $.ajax({
        type: "POST",
        url: "/excel/export",
        async: true,
        cache: false,
        data: {
            household_id: $("#household_id").val(),
            start_date: $("#start_date").val(),
            end_date: $("#end_date").val(),
            export_categories: selected_categories,
            min_amount: $("#min_amount").val(),
            max_amount: $("#max_amount").val()
        }
    });

    req.done(function(data){
        btn.click(getFile);
        btn_text.text('Start Exporting');
        if(data.success){
            $("#export_download_link").attr('href', '/excel/download/' + data.download_id);
            $("#start_export").hide();
            $("#export_download_link").show();
        }
        else{
            $("#start_export").hide();
            $("#export_download_link").show();
        }
    });

    req.fail(function(data){
        btn.click(getFile);
        btn_text.text('Failed, try again');
    });
}