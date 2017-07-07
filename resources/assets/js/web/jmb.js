$(document).ready(function () {
    $('#country').on('change', function () {
        var selectedCountry = $(this).val();
        $('#city').empty();
        $('#city').append('<option value="">---</option>');
        $.each(allCities[selectedCountry], function(index, val) {
            var option = '<option value="' + index + '">' + val + '</option>';
            $('#city').append(option);
        });
    });
})