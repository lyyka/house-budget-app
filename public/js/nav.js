$(document).ready(docReady);

function docReady(e){
    $("#open_menu").click(toggleMenuLeft);
    $("#close_menu").click(toggleMenuLeft);

    $(window).resize(onResize);
    onResize(null);
}

function toggleMenuLeft(e){
    $("#menu_wrap").toggle();
}

function onResize(e){
    const wind = $(window);
    
    if(wind.width() <= 992){
        $("#menu_items_list").addClass('container');
        $("#menu_wrap").removeClass('w-25');
        $("#menu_wrap").addClass('w-100');
    }
    else{
        $("#menu_items_list").removeClass('container');
        $("#menu_wrap").removeClass('w-100');
        $("#menu_wrap").addClass('w-25');
    }
}