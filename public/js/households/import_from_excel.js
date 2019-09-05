$(document).ready(function(){
    $("#excel_import_table").on("change", fileSelectedForUpload);
});

function fileSelectedForUpload(e){
    const input = document.getElementById('excel_import_table');

    if (input.files) {
        if (input.files.length > 1) {
            alert('You can select only one file at a time.');
        }
        else {
            $.each(input.files, readAndPreview);
        }
    }

    function readAndPreview(i, file) {

        if (!/\.(xlsx)$/i.test(file.name)) {
            alert(file.name + " is not a .xlsx file");
        }

        var reader = new FileReader();

        $(reader).on("load", function (e) {
            if (file.type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $("#excel_import_show_when_selected").show();
                $("#import_file_name").html("Selected: <span class = 'font-weight-bold'>" + file.name + "</span>");                
            }
        });
        reader.readAsDataURL(file);
    }
}