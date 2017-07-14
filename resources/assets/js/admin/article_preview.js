$(function () {
    $('.next-to-confirm').on('click', function () {
        $('form.form-confirm').submit();
    });

    var divStyle = $('.title-preview')[0].style;
    $('.colorpicker-element').colorpicker({
        color: divStyle.backgroundColor
    }).on('changeColor', function(ev) {
        divStyle.backgroundColor = ev.color.toHex();
        $('.title-bg-color').val(ev.color.toHex());
    });

    $('.image-item').on('click', function () {
        if (!$(this).hasClass('preview-selected')) {
            $(this).parents('.list-image-preview').find('.preview-selected').removeClass('preview-selected');
            $(this).addClass('preview-selected');
            $('.selected-image img').attr('src', $(this).attr('data-src'));
            $('.thumbnail').val($(this).attr('data-src'));
        }
    });

    $('.btn-preview').on('click', '.btn', function () {
        $(this).parents('.btn-preview').find('a.btn').each(function() {
            $(this).removeClass('btn-success').removeClass('active');
        });

        $(this).addClass('active').addClass('btn-success');

        $('.breadcrumb-preview').find('strong').each(function() {
            $(this).addClass('hidden');
        });

        if ($(this).attr('href') == '#mobile-preview') {
            $('.breadcrumb-preview').find('.mb-preview').removeClass('hidden');
        } else if ($(this).attr('href') == '#pc-preview') {
            $('.breadcrumb-preview').find('.pc-preview').removeClass('hidden');
        } else {
            $('.breadcrumb-preview').find('.thumb-preview').removeClass('hidden');
        }
    });
});
