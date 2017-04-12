$(function () {
    $('.dropdown')
        .hover(function () { $(this).find('ul.dropdown-menu').slideDown('fast'); },
               function () { $(this).find('ul.dropdown-menu').slideUp('fast'); });

});