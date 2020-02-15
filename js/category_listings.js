jQuery(function ($) {

    $('body').on('click', '.category_btn', function (e) {
        if ($('.fa-caret-down').is(':visible')) {
            $('.categories_list').hide();
            $('.fa-caret-down').hide();
            $('.fa-caret-right').show();
        } else {
            $('.categories_list').show();
            $('.fa-caret-down').show();
            $('.fa-caret-right').hide();
        }
    })


})
