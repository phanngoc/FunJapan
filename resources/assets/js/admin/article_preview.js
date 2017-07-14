$(function () {
    $('.next-to-confirm').on('click', function () {
        var validateUrl = $('form.form-confirm').attr('data-validate-url');
        var formData = $('form.form-confirm').serialize();
        var thisElement = $(this);
        thisElement.attr('disabled', true);
        thisElement.find('.fa-spinner').removeClass('hidden');

        $.ajax({
            url: validateUrl,
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('form.form-confirm').submit();
                } else {
                    var message = '';
                    for (let key in response.message) {
                        message += '<p>' + response.message[key] + '</p>';
                    }
                    $('.alert-error-section').removeClass('hidden')
                        .find('.alert.alert-danger').empty().append(message);
                    $('html, body').animate({
                        scrollTop: $('.alert-error-section').offset().top
                    }, 700);

                    thisElement.attr('disabled', false);
                    thisElement.find('.fa-spinner').addClass('hidden');
                }
            }
        });
    });

    $('.btn-back').on('click', function () {
        $(this).attr('disabled', true);
        $(this).find('.fa-spinner').removeClass('hidden');
        $('.back-to-create').val(true);
        $('form.form-confirm').submit();
    });

    var divStyle = $('.title-preview')[0].style;
    $('.colorpicker-element').colorpicker({
        color: divStyle.backgroundColor
    }).on('changeColor', function(ev) {
        divStyle.backgroundColor = ev.color.toString('rgba');
        $('.title-bg-color').val(ev.color.toString('rgba'));
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
