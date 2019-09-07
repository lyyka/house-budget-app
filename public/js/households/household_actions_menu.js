$(document).ready(function(){
    $("#edit_household").click(function(e){
        $("#editHousehold").modal('show');
    });

    $("#share_household").click(function(e){
        $("#shareHousehold").modal('show');
    });

    $("#shared_with").click(function(e){
        $("#sharedWithList").modal('show');
    });
});