$(document).ready(docReady);

function docReady(e){
    $("#open_categories_dropdown").click(toggleCategoriesDropdown);
    $(".category_item").click(categoriesDropdownItemSelected);
}

function toggleCategoriesDropdown(e){
    const dropdown = $(this).parent().find("#categories_dropdown");
    const icon = $(this).find('i');
    icon.toggleClass('fa-chevron-circle-down fa-chevron-circle-up')
    dropdown.slideToggle();
}

function categoriesDropdownItemSelected(e){
    const value = $(this).find('.category_name').text();
    $("#category").val(value);
    $("#categories_dropdown_text").html($(this).html());
}