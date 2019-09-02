$(document).ready(docReady);

function docReady(e){
    $("#open_categories_dropdown").click(toggleCategoriesDropdown);
    $(".category_item").click(categoriesDropdownItemSelected);
}

function toggleCategoriesDropdown(e){
    toggle();
}

function toggle(){
    const dropdown = $("#open_categories_dropdown").parent().find("#categories_dropdown");
    const icon = $("#open_categories_dropdown").find('i');
    icon.toggleClass('fa-chevron-circle-down fa-chevron-circle-up')
    dropdown.toggle();
}

function categoriesDropdownItemSelected(e){
    const value = $(this).find('.category_id').text();
    
    $("#category").val(value);
    $("#categories_dropdown_text").html($(this).html());

    toggle();
}