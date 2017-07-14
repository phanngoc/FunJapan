$(function () {
    $('.article-tag').tagsinput({
        cancelConfirmKeysOnEmpty: false,
        typeahead: {
            source: function(query) {
                return $.get($('.article-tag').data('url') + '/?query='+ query);
            },
            afterSelect: function(val) {
                this.$element.val('');
            },
            items: 5,
            autoSelect: false,
        },
       // freeInput: true,
        trimValue: true,
        tagClass: 'label label-warning',
    });

    $('.input-group.date').datepicker({
        todayBtn: 'linked',
        format: 'yyyy-mm-dd',
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    }).on('show', function (e) {
        var monthYear = $('.table-condensed thead tr th:eq(2).datepicker-switch').text().split(' ');
        var month = monthYear[0];
        var year = parseInt(monthYear[1]);
        var today = new Date();
        var monthToday = today.toLocaleString('en-us', { month: 'long' });
        var dateToday = today.getDate();
        if (year == today.getUTCFullYear() && month == monthToday) {
            $('table.table-condensed tbody tr td').each(function () {
                if ($(this).text() == dateToday && !$(this).hasClass('old')) {
                    $(this).addClass('active-today');
                }
            });
        }
    });

    $('.clockpicker').clockpicker();

    getCategoriesByLocale($('#locale_id').attr('data-url'), $('#locale_id').val(), categoryId);

    $('#locale_id').on('change', function () {
        var url = $(this).attr('data-url');
        getCategoriesByLocale(url, $(this).val());
    });

    var contentMarkdown = $('.article-content').val();

    $('.article-content').markdown({
        autofocus:false,
        onChange: function (e) {
            editor.setContent($('.article-content').data('markdown').parseContent());
        },
        savable:false
    });

    var editor = new MediumEditor(document.querySelector(".editable"), {
        extensions: {
            markdown: new MeMarkdown(function (md) {
                $('.article-content').data('markdown').setContent(md);
            }),
            spreadsheet: new MediumEditorSpreadsheet()
        },
        buttonLabels: 'fontawesome',
        toolbar: {
            buttons: [
                'bold', 'italic', 'underline', 'anchor', 'h2', 'h3',
                'quote', 'justifyCenter', 'justifyLeft', 'spreadsheet'
            ],
            static: true,
            sticky: true
        }
    });

    $('.editable').mediumInsert({
        editor: editor,
        addons: {
            images: {
                deleteScript: $('.upload-file-data').attr('data-url-delete'),
                deleteMethod: 'POST',
                fileDeleteOptions: {
                },
                fileUploadOptions: {
                    url: $('.upload-file-data').attr('data-url-upload'),
                    maxFileSize: $('.upload-file-data').attr('data-max-size'),
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
                },
                messages: {
                    acceptFileTypesError: $('.upload-file-data').attr('data-message-file-type-error'),
                    maxFileSizeError: $('.upload-file-data').attr('data-message-size-error')
                },
                uploadCompleted: function ($el, data) {
                    $el.attr('data-image-path', data.result.files[0].imagePath);
                },
                uploadFailed: function (uploadErrors, data) {
                    var message = '';
                    for (let key in uploadErrors) {
                        message += '<p>' + uploadErrors[key] + '</p>';
                    }
                    $('.alert-error-section').removeClass('hidden')
                        .find('.alert.alert-danger').empty().append(message);
                    $('html, body').animate({
                        scrollTop: $('.alert-error-section').offset().top
                    }, 700);
                }
            }
        }
    });

    editor.subscribe('editableInput', function (event, editable) {
        var allContents = editor.serialize();
        var elContent = allContents['element-0'].value;
        $('input[name="contentMedium"]').val(elContent);
    });

    if (typeof showMarkdown != 'undefined' && showMarkdown != '') {
        $('.medium-section').hide();
        $('.md-editor').show();
    } else {
        $('.medium-section').show();
        $('.md-editor').hide();
    }

    $('input[name="switch_editor"]').on('click', function () {
        if ($(this).val() == 1) {
            $('.medium-section').show();
            $('.md-editor').hide();
        } else {
//          $('.article-content').data('markdown').setContent(toMarkdown(editor.getContent()));
            $('.medium-section').hide();
            $('.md-editor').show();
        }
    });

    $('.article-content').data('markdown').setContent(contentMarkdown);

    $('.create-action').on('click', function () {
        $('.save-draft-input').val(false);
        var thisElement = $(this);

        if (thisElement.hasClass('save-draft')) {
            $('.save-draft-input').val(true);
        }

        thisElement.attr('disabled', true);
        thisElement.find('.fa-spinner').removeClass('hidden');

        var url = thisElement.attr('data-url');
        var thisForm = thisElement.parents('form.article-create');
        var formData = thisForm.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    if (thisElement.hasClass('save-draft')) {
                        $('form.article-create').submit();
                    } else {
                        $('#confirm-check-preview').modal('show');
                        $('.alert-error-section').addClass('hidden');
                    }
                } else {
                    var message = '';
                    for (let key in response.message) {
                        message += '<p>' + response.message[key].join(' ') + '</p>';
                    }
                    $('.alert-error-section').removeClass('hidden')
                        .find('.alert.alert-danger').empty().append(message);
                    $('html, body').animate({
                        scrollTop: $('.alert-error-section').offset().top
                    }, 700);
                }

                thisElement.attr('disabled', false);
                thisElement.find('.fa-spinner').addClass('hidden');
            }
        });
    });

    $('.preview-mode-btn').on('click', function () {
        $('.preview-mode').val($(this).attr('data-value'));
        $('#confirm-check-preview').modal('hide');
        $('form.article-create').submit();
    });

    $('.article-form-edit').on(
        'change',
        'select[name="author_id"], select[name="client_id"], select[name="sub_category_id"], select[name="category_id"]',
        function () {
        if ($(this).val() != '') {
            swal(warningChangeTxt, '', 'warning');
        }
    });
});

function getCategoriesByLocale(url, localeId, selected = '') {
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            locale_id: localeId
        },
        success: function (data) {
            var html = '<option value="">' + $('#category_id').attr('data-select-text') + '</option>';
            for (let key in data) {
                if (key == selected) {
                    html += '<option value="' + key + '" selected>' + encodeHTML(data[key]) + '</option>';
                } else {
                    html += '<option value="' + key + '">' + encodeHTML(data[key]) + '</option>';
                }
            }

            $('#category_id').empty().append(html);
        }
    });
}
