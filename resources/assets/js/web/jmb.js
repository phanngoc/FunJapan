$(document).ready(function () {
    $('#add-input').on('click', function () {
        var element = $('#given-name-section').children('.hidden');
        $('#lastName').attr('disabled', 'disabled');
        $('#midName').attr('disabled', 'disabled');
        if (element.length == 2) {
            $('#firstName2_block').removeClass('hidden');
            $('#firstName2').attr('name', 'first_name2');
            $('#remove-2').removeClass('hidden');
        } else {
            $('#firstName3_block').removeClass('hidden');
            $('#firstName3').attr('name', 'first_name3');
            $(this).addClass('hidden');
            $('#remove-2').addClass('hidden');
            $('#remove-3').removeClass('hidden');
        }
    })

    $('#remove-2').on('click', function () {
        $('#lastName').removeAttr('disabled');
        $('#midName').removeAttr('disabled');
        $('#firstName2_block').addClass('hidden');
        $('#firstName2').attr('name', '');
        $(this).addClass('hidden');
        $('#firstName3').val('');
        $('#add-input').removeClass('hidden');
    })

    $('#remove-3').on('click', function () {
        $('#firstName3_block').addClass('hidden');
        $('#firstName3').attr('name', '');
        $(this).addClass('hidden');
        $('#firstName3').val('');
        $('#remove-2').removeClass('hidden');
    })

    $('#add-address-3').on('click', function (e) {
        $('#input-address-3').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $('#add-address-4').on('click', function (e) {
        $('#input-address-4').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $('#smTerms').on('click', function (e) {
        var checked = $(this).is(':checked');
        $('#inputTerm').val(checked);
    });

    if (terms) {
        $('#smTerms').attr('checked', 'checked');
    }

    $('#country').on('change', function () {
        var selectedCountry = $(this).val();
        $('#city').empty();
        $('#city').append('<option value="">---</option>');
        $.each(allCities[selectedCountry], function(index, val) {
            var option = '<option value="' + index + '">' + val + '</option>';
            $('#city').append(option);
        });
    });

    if ((typeof oldInputs['city'] != 'undefined') && (typeof oldInputs['country'] != 'undefined')) {
        var selectedCountry = oldInputs['country'];
        $('#city').empty();
        $('#city').append('<option value="">---</option>');
        $.each(allCities[selectedCountry], function(index, val) {
            if (oldInputs['city'] == index) {
                var option = '<option value="' + index + '" selected="selected">' + val + '</option>';
            } else {
                var option = '<option value="' + index + '">' + val + '</option>';
            }
            $('#city').append(option);
        });
    }

})